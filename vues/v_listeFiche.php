

<h2>Suivre le paiement </h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner une fiche de frais : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=suivrePaiement&action=afficheDetail" 
              method="post" role="form">
            <select name="visiteur" id="visiteur_select" class="form-control">
             <?php
                foreach ($visiteurFiche as $visiteur){ ?>
                    <option value= <?= $visiteur['id']  ?> > <?= $visiteur['nom'] ?> <?= $visiteur['prenom'] ?> </option>
            <?php } ?>
            </select>

            <select name="mois" id="mois_select" class="form-control">
             <?php
                foreach ($moisFiche as $mois){ ?>
                    <option value= <?= $mois['mois']  ?> > <?= $mois['mois'] ?> </option>
            <?php } ?>
            </select>
            

            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
        
        </form>
    </div>
</div>