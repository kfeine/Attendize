<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Konekt\PdfInvoice\InvoicePrinter;

class GenerateInvoice extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $reference;
    protected $order_reference;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reference)
    {
        Log::info("Generating invoice: #" . $reference);
        $this->reference = $reference;
        $this->order_reference = explode("-", $reference)[0];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file_path = public_path(config('attendize.event_pdf_invoices_path')) . '/' . $this->reference . '.pdf';
        $order = Order::where('order_reference', $this->order_reference)->first();

        $invoice = new InvoicePrinter("A4", "€ ", "fr");
        $invoice->setLogo(public_path($order->event->organiser->full_logo_path));
        $invoice->setColor("#b8db74");
        $invoice->setType("Facture");
        $invoice->setReference($this->order_reference);
        $invoice->setDate(date('d/m/Y',time()));
        $invoice->setTime(date('H \h i',time()));
        $invoice->setFrom(array(utf8_decode("Entente Évangélique des CAEF"), "18bis rue Pasteur", "26000 VALENCE", "04 26 50 27 37"));
        $invoice->setTo(array($order->first_name . " " . $order->last_name, $order->address1, $order->postal_code . " " . $order->city, $order->email));

        // add items
        foreach ($order->orderItems as $order_item) {
            $invoice->addItem($order_item->title, "", $order_item->quantity, 0, $order_item->unit_price, 0, $order_item->unit_price * $order_item->quantity);
            foreach($order_item->orderItemOptions as $option) {
                $invoice->addItem(" + " . $option->title, "", 1, 0, $option->price, 0, $option->price);
            }
        };
        // if discount, insert it
        if($order->discount) {
            $invoice->addItem("Réduction : " . $order->discount->title, "", 1, 0, 0, 0, ($order->discount->type == "amount") ? $order->discount->price : -1 * $order->amount * (1/(1+$order->discount->price/100)-1));
        }

        $invoice->addTotal("Total",$order->amount,true);

        // if payé
        //$invoice->addBadge("Payment Paid");
        if ($order->order_status_id == 1) {
            $invoice->addTitle("Commande payée");
            $invoice->addParagraph("Cette commande a entièrement été réglée");
        }
        // if not payé
        else {
            $invoice->addTitle("Commande en attente de paiement");
            $invoice->addParagraph("Cette commande n'a pas été réglée");
            $invoice->addParagraph("Paiement par chèque à l’ordre de l’Entente Evangélique des CAEF");
            $invoice->addParagraph("ou par virement :\n    IBAN : FR11 2004 1010 0710 5500 3R03 896\n    BIC : PSSTFRPPLYO");
        }

        $invoice->setFooternote(utf8_decode("Entente Évangélique des CAEF - 18bis rue Pasteur - 26000 Valence"));
        $invoice->render($file_path,'F');
        Log::info("Invoice generated!");
    }
}
