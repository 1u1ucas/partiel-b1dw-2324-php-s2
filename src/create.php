<?php require_once 'parts/header.php'; ?>


<div class="container">
    <h1>Créer un ticket</h1>
    <form action="scripts/addTicket.php" method="POST">
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select class="form-select" id="categorie" name="categorie">
                <option value="Hommes">Hommes</option>
                <option value="Femmes">Femmes</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="groupe" class="form-label">Groupe</label>
            <input type="text" class="form-control" id="groupe" name="groupe" maxlength="10">
        </div>
        <div class="mb-3">
            <label for="equipe1" class="form-label">Nom de l'équipe 1</label>
            <input type="text" class="form-control" id="equipe1" name="equipe1" maxlength="50">
        </div>
        <div class="mb-3">
            <label for="equipe2" class="form-label">Nom de l'équipe 2</label>
            <input type="text" class="form-control" id="equipe2" name="equipe2" maxlength="50">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input class="form-control" id="description" name="description">
        </div>
        <div><label for="price" class="form-label">Prix</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01">
        </div>
        <div class="mb-3">
            <label for="date_heure" class="form-label">Date et heure</label>
            <input type="datetime-local" class="form-control" id="date_heure" name="date_heure">
        </div>
        <div class="mb-3">
            <label for="lieu" class="form-label">Lieu</label>
            <input type="text" class="form-control" id="lieu" name="lieu" maxlength="100">
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>




    <?php require_once 'parts/footer.php'; ?>