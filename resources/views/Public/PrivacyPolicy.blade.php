<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
    <head>
        <title>Politique de respect de la vie privée</title>


        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />

        <!-- Open Graph data -->
        <meta property="og:title" content="Politique vie privée" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="/privacy/policy" />
        <meta property="og:site_name" content="Attendize.com" />
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('head')

       {!!HTML::style(config('attendize.cdn_url_static_assets').'/assets/stylesheet/frontend.css')!!}

        <!--Bootstrap placeholder fix-->
        <style>
            ::-webkit-input-placeholder { /* WebKit browsers */
                color:    #ccc !important;
            }
            :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
                color:    #ccc !important;
                opacity:  1;
            }
            ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color:    #ccc !important;
                opacity:  1;
            }
            :-ms-input-placeholder { /* Internet Explorer 10+ */
                color:    #ccc !important;
            }

            input, select {
                color: #999 !important;
            }

            .btn {
                color: #fff !important;
            }

        </style>
    </head>
    <body class="attendize">
        <div id="event_page_wrap" vocab="http://schema.org/" typeof="Event">

            <section id="intro" class="content">
            <div class="container">
                <div class="col-md-9">
                    <a href="/privacy/policy/"><h1 property="name">Politique de protection de la vie privée</h1></a>
                </div>
            </div>
            </section>

            <section class="content">
                <div class="container">
                    <h2>Données récoltées</h2>
                    <p>Afin de pouvoir gérer les inscriptions aux événements (congrès annuel CAEF) et leur logistique (logements, repas, communication, etc.), les données suivantes sont récoltées sur chaque participant :</p>
                    <ul>
                        <li>Civilité, nom, prénom</li>
                        <li>Adresse email</li>
                        <li>Adresse postale</li>
                        <li>Église d'origine</li>
                        <li>Âge</li>
                    </ul>
                    <p>Concernant la personne effectuant la commande du ou des inscriptions, ces données suivantes sont demandées pour des raisons légales.</p>
                    <p>Ces données sont récoltées avec votre consentement lors de l'inscription à l'événement.</p>

                    <h2>Finalités, traitements et utilisation</h2>
                    <p>Les données récoltées sont utilisées exclusivement pour :</p>
                    <ul>
                        <li>La gestion des commandes et des paiements (données de la personne effectuant la commande) ;</li>
                        <li>La gestion de l'inscription et de l'organisation à l'événement concerné, notamment en termes de communication.</li>
                    </ul>
                    <p>Les données ne seront pas utilisées à d'autres fins, ni transmises à d'autres organisations, sans votre consentement explicite.</p>

                    <h2>Localisation</h2>
                    <p>Les données (données de production et sauvegardes) sont conservées uniquement sur des serveurs gérés par l'organisation et localisés en France</p>

                    <h2>Durée de conservation</h2>
                    <p>Les données sont supprimées des serveurs un an après l'événement.</p>

                    <h2>Droits et législation</h2>
                    <p>Nous vous rappelons que vos droits et nos devoirs concernant la protection des données à caractères personnelles, ainsi que les définitions, sont inscrites dans le <a href="https://eur-lex.europa.eu/legal-content/FR/TXT/?uri=CELEX%3A32016R0679">Règlement (UE) 2016/679 (règlement général sur la protection des données ou RGPD)</a>.</p>
                    <p>Vos droits incluent :</p>
                    <ul>
                        <li>Droit d'accès à vos données ;</li>
                        <li>Droit de rectification de vos données ;</li>
                        <li>Droit d'effacement de vos données ;</li>
                        <li>Droit à la limitation du traitement ;</li>
                        <li>Droit à la portabilité des données ;</li>
                        <li>Droit d'opposition au traitement.</li>
                    </ul>
                    <p>Pour toute demande d'exercice de ces droits, merci d'adresse une demande par email à <a href="mailto:privacy@caef.net">privacy@caef.net</a>, ou par courrier à : <i>Entente Evangélique des CAEF, 18 bis rue Pasteur, 26000 Valence</i></p>

                    <h2>Mesures de protection</h2>
                    <p>Les mesures suivantes sont mises en place afin de protéger vos données :</p>
                    <ul>
                        <li>Bonnes pratiques de sécurisation des serveurs (pare-feu, mises à jours, etc.) ;</li>
                        <li>Accès au site uniquement en HTTPS, assurant le chiffrement des échanges ;</li>
                        <li>Chiffrement des sauvegardes.</li>
                    </ul>

                    <h2>Contact</h2>
                    <p>Pour toute demande ou information, merci d'adresse une demande par email à <a href="mailto:privacy@caef.net">privacy@caef.net</a>, ou par courrier à : <i>Entente Evangélique des CAEF, 18 bis rue Pasteur, 26000 Valence</i></p>
                </div>
            <section>
        </div>

    </body>
</html>
