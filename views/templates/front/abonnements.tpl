{extends file='page.tpl'}
{block name="page_content"}
    <div class="abonnement-header">
        <h1>Choisissez l'abonnement<br /> Passion Nature</h1>
        <img src="/themes/karinejeff/assets/img/abonnement/abonnement.png" alt="abonnement" /></div>
    <div class="abonnement-description">
        <p>Texte sur 2 lignes. Soyez ainsi remercié de votre fidélité et abonnez-vous à Passion Nature, sans engagement et résiliable tout moment.</p>
    </div>
    <div class="bloc-abonnement">

        <div class="bloc-abonnement-text">
            <h2>Avec l'abonnement <strong>Passion Nature</strong>, <br />profitez immédiatement de nombreux avantages</h2>
            <div class="avantages">
                <div class="avantage">
                    <h3>Bénéficiez de <br />5% <span>de remise</span></h3>
                </div>
                <div class="avantage">
                    <h3>Frais de port <br />offerts <span>sur toutes <br />vos commandes</span></h3>
                </div>
                <div class="avantage">
                    <h3>Remises <br />exclusives <span>plus de 3 fois <br />par an</span></h3>
                </div>
                <div class="avantage">
                    <h3>Guides <br />personnalisés <span>sur la nutrition, <br />la cuisine</span></h3>
                </div>
            </div>
        </div>

        <div class="abonnement">
            {foreach $abonnements as $abonnement}
                <div class="card">
                    <div class="abonnement-info">
                        <div class="abonnement-title">
                            <h2>{$abonnement.titre}</h2>
                            <div class="abonnement-sous-title">{$abonnement.sous_titre}</div>
                        </div>
                        <div class="price"><span>{$abonnement.prix} €</span></div>
                    </div>
                    <div class="abonnement-image"><img src="{$imgPath}{$abonnement.image}" alt="mois.png" /></div>
                    <div class="add-to-card">
                        <form method="post" action="{$link}">
                            <input name='id_abonnement' type="hidden" value="{$abonnement.id_abonnement}" class="hidden" />
                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            {/foreach}


        </div>
        <p class="footer">Jusqu'au 31 octobre, le premier mois d'abonnement est offert</p>
    </div>
{/block}