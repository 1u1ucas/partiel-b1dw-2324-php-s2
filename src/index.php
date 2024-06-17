<?php require_once 'parts/header.php';


$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'asc' : 'desc';
// Determine the opposite order
$toggleOrder = $order === 'asc' ? 'desc' : 'asc';

$posts = [];


$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

if (isset($_GET['categorie']) && strlen($_GET['categorie'])) {
    if ($_GET['categorie'] == "Hommes" || $_GET['categorie'] == "Femmes") {
        $categorie = $_GET['categorie'];
        $request = $connectDatabase->prepare("SELECT * FROM post ORDER BY categorie = :categorie DESC");
        $request->bindParam(':categorie', $categorie);
        $request->execute();
        $posts = $request->fetchAll();
    }
} elseif (isset($_GET['groupe']) && strlen($_GET['groupe'])) {

    $request = $connectDatabase->prepare("SELECT * FROM post ORDER BY groupe = :groupe DESC");
    $request->bindParam(':groupe', $_GET['groupe']);
    $request->execute();
    $posts = $request->fetchAll();
} elseif (isset($_GET['lieu']) && strlen($_GET['lieu'])) {
    $request = $connectDatabase->prepare("SELECT * FROM post ORDER BY lieu = :lieu DESC");
    $request->bindParam(':lieu', $_GET['lieu']);
    $request->execute();
    $posts = $request->fetchAll();
} else {
    $request = $connectDatabase->prepare("SELECT * FROM post ORDER BY `prix` $order");
    $request->execute();
    $posts = $request->fetchAll();
}
?>


<div class="filters">
    <div class="container">
        <h1>Football</h1>
        <form class="filter" action="" method="GET">
            <h2>Filtrer par</h2>
            <div class="filter-item">
                <label for="categorie">Catégorie</label>
                <select class="form-select" id="categorie" name="categorie">
                    <option value="">--veuillez choisir--</option>
                    <option value="Hommes">Hommes</option>
                    <option value="Femmes">Femmes</option>
                </select>
            </div>
            <div class="filter-item">
                <label for="groupe">Groupe</label>
                <input type="text" class="form-control" name="groupe" id="groupe" maxlength="10">
            </div>
            <div class="filter-item">
                <label for="prix">Lieu</label>
                <input type="text" class="form-control" name="lieu" id="lieu">
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</input>
        </form>
        <a style="all: unset" href="?order=<?php echo $toggleOrder; ?>">
            <button class="btn btn-primary">
                <?php echo $order === 'asc' ? '<i class="fa-solid fa-arrow-up-wide-short"></i>' : '<i class="fa-solid fa-arrow-down-short-wide"></i>'; ?>
            </button>
        </a>
    </div>
</div>

<div class="post-list">
    <?php foreach ($posts as $index => $post): ?>
        <div class="post container  mb-3">
            <div class="leftPart">
                <div class="top">
                    <h1>Football</h1>
                    <i class="categorie fa-solid <?php if ($post['categorie'] == "Hommes"): ?>
                fa-mars <?php elseif ($post['categorie'] == "Femmes"): ?>
                    fa-venus <?php endif; ?>"></i>
                </div>
                <div class="content">
                    <p>
                        <?php
                        if (strlen($post['description']) > 100):
                            echo substr($post['description'], 0, 100) . '...'; ?>
                            <a href="ticket.php?id=<?php echo $post['id']; ?>">Voir plus</a>
                        <?php else:
                            echo $post['description'];
                            ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="bottom">
                    <?php
                    $post['date_heure'] = explode(" ", $post['date_heure']);

                    foreach ($post['date_heure'] as $date):
                        ?>
                        <p><?php echo htmlspecialchars($date) ?></p>
                        <p>|</p>
                    <?php endforeach; ?>
                    <p><?php echo htmlspecialchars($post['lieu']) ?></p>
                    <p>|</p>
                    <a href="scripts/deleteTicket.php?id=<?php echo $post['id']; ?>">delete</a>
                </div>
            </div>
            <div class="offer">
                <?php
                $request = $connectDatabase->prepare("SELECT * FROM bid WHERE post_id = :post_id");
                $request->bindParam(':post_id', $post['id']);
                $request->execute();
                $bids = $request->fetchAll();


                $numberBids = count($bids);

                $lowestAmount = PHP_INT_MAX;


                foreach ($bids as $bid) {
                    // Étape 3: Comparer et mettre à jour le montant le plus faible
                    if ($bid['montant'] < $lowestAmount) {
                        $lowestAmount = $bid['montant'];
                    }
                }

                if ($numberBids == 0) {
                    $lowestAmount = 0;
                }
                ;

                ?>
                <h4><?php echo htmlspecialchars($numberBids) ?> offre(s) à partir de
                    <?php echo htmlspecialchars($lowestAmount) ?>€
                </h4>
                <a href="ticket.php?id=<?php echo $post['id']; ?>">Voir les offres</a>
            </div>
        </div>

    <?php endforeach; ?>
</div>

<?php require_once 'parts/footer.php'; ?>