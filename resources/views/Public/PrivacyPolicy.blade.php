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
                        <li>Téléphone</li>
                        <li>Adresse email</li>
                        <li>Date de naissance</li>
                        <li>Adresse postale</li>
                        <li>Église d'origine</li>
                        <li>Âge</li>
                    </ul>
                    <p>Concernant la personne effectuant la commande du ou des participants, ces données suivantes sont demandées pour des raisons légales.</p>
                    <p>Ces données sont récoltées avec votre consentement lors de l'inscription à l'événement.</p>

                    <h2>Finalités, traitements et utilisation</h2>
                    <p>Les données récoltées sont utilisées exclusivement pour :</p>
                    <ul>
                        <li>La gestion des commandes et des paiements (données de la personne effectuant la commande), la gestion de l'inscription et de l'organisation à l'événement concerné, notamment en termes de communication (traitement obligatoire pour l'inscription). Ce traitement nécessite les données suivantes au sujet de la personne effectuant la commande :
                            <ul>
                                <li>Civilité,</li>
                                <li>Nom,</li>
                                <li>Prénom,</li>
                                <li>Adresse email,</li>
                                <li>Téléphone,</li>
                                <li>Adresse postale,</li>
                            </ul>
                        et pour les participants :
                            <ul>
                                <li>Civilité,</li>
                                <li>Nom,</li>
                                <li>Prénom,</li>
                                <li>Date de naissance,</li>
                                <li>Téléphone,</li>
                                <li>Adresse postale,</li>
                                <li>Église fréquentée ;</li>
                            </ul>
                        </li>
                        <li>L'impression dans le livret distribué à chaque participant sous format papier (traitement facultatif) des données suivantes :
                            <ul>
                                <li>Nom,</li>
                                <li>Prénom,</li>
                                <li>Église fréquentée ;</li>
                            </ul>
                        </li>
                        <li>Contacter les personnes concernées au sujet de l'actualité des CAEF (2 emails par an) et des événements suivants (prochains congrès) via l'adresse mail.</li>
                    </ul>
                    <p>Ces trois traitements sont indépendants, et vous pouvez exercer vos droits pour chacun d'entre eux.</p>
                    <p>Les données ne seront pas utilisées à d'autres fins, ni transmises à d'autres organisations, sans votre consentement explicite.</p>

                    <h2>Localisation</h2>
                    <p>Les données (données de production et sauvegardes) sont conservées uniquement sur des serveurs gérés par l'organisation et localisés en France.</p>

                    <h2>Durée de conservation</h2>
                    <p>Les données d'inscription (hors informations de commande pour des raisons légales) sont supprimées des serveurs trois ans après l'événement.</p>

                    <h2>Droits et législation</h2>
                    <p>Nous vous rappelons que vos droits et nos devoirs concernant la protection des données à caractère personnel, ainsi que les définitions, sont inscrites dans le <a href="https://eur-lex.europa.eu/legal-content/FR/TXT/?uri=CELEX%3A32016R0679">Règlement (UE) 2016/679 (règlement général sur la protection des données ou RGPD)</a>.</p>
                    <p>Vos droits incluent :</p>
                    <ul>
                        <li>Droit d'accès à vos données ;</li>
                        <li>Droit de rectification de vos données ;</li>
                        <li>Droit d'effacement de vos données ;</li>
                        <li>Droit à la limitation du traitement ;</li>
                        <li>Droit à la portabilité des données ;</li>
                        <li>Droit d'opposition au traitement.</li>
                    </ul>
                    <p>Pour toute demande d'exercice de ces droits, merci d'adresser une demande par email à <a href="mailto:vieprivee@caef.net">vieprivee@caef.net</a>, ou par courrier à : <i>Entente Evangélique des CAEF, 18 bis rue Pasteur, 26000 Valence</i></p>

                    <h2>Mesures de protection</h2>
                    <p>Les mesures suivantes sont mises en place afin de protéger vos données :</p>
                    <ul>
                        <li>Bonnes pratiques de sécurisation des serveurs (pare-feu, mises à jours, etc.) ;</li>
                        <li>Accès au site uniquement en HTTPS, assurant le chiffrement des échanges ;</li>
                        <li>Sauvegardes chiffrées.</li>
                    </ul>

                    <h2>Contact</h2>
                    <p>Pour toute demande ou information, merci d'adresser une demande par email à <a href="mailto:vieprivee@caef.net">vieprivee@caef.net</a>, ou par courrier à : <i>Entente Evangélique des CAEF, 18 bis rue Pasteur, 26000 Valence</i></p>
                </div>
            <section>
        </div>

    </body>
</html>
