<?php require_once 'parts/header.php';

$id = $_GET['id'];

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$request = $connectDatabase->prepare("SELECT * FROM post WHERE id = :id ");

$request->bindParam(':id', $id);

$request->execute();

$post = $request->fetch();
?>

<div class=" container  mb-3">
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
                echo htmlspecialchars($post['description'])
                    ?>
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
        </div>
    </div>
    <div class="offer">
        <?php
        $request = $connectDatabase->prepare("SELECT * FROM bid WHERE post_id = :post_id ORDER BY `montant` DESC");
        $request->bindParam(':post_id', $post['id']);
        $request->execute();
        $bids = $request->fetchAll();

        $highestBid = 0;
        foreach ($bids as $bid) {
            if ($bid['montant'] > $highestBid) {
                $highestBid = $bid['montant'] + 1;
            }
        }
        ?>

        <form action="scripts/addBid.php" method="POST">
            <label for="montant">Montant</label>
            <input type="number" name="montant" id="montant" step="0.01" min="<?php echo $highestBid ?>">
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <input type="submit">
        </form>

        <?php foreach ($bids as $index => $bid): ?>
        <div class="bid">
            <p>Offre n°<?php echo $index + 1 ?></p>
            <p>|</p>
            <p><?php echo htmlspecialchars($bid['montant']) ?> €</p>
        </div>
        <?php endforeach; ?>



        <?php require_once 'parts/footer.php' ?>