
<h2>Valider les frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un visiteur et un mois : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=validerFrais&action=voirFrais" 
              method="post" role="form">
            <select name="user" id="user_select" class="form-control">
             <?php
                foreach ($listeUser as $visiteur){ ?>
                    <option value= <?= $visiteur['id']  ?> > <?= $visiteur['prenom'] ?>  <?= $visiteur['nom'] ?> </option>
            <?php } ?>
            </select>
    
            <select name="mois" id="mois_select" class="form-control">
            <?php 
                foreach ($listeMois as $unMois){ ?>
                    <option value= <?= $unMois['mois'] ?> > <?= $unMois['mois'] ?>  </option>
            <?php } ?>
            </select>

            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
        
        </form>
    </div>
</div>