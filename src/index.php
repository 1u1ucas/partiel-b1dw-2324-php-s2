<?php require_once 'parts/header.php'; ?>

<?php

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$request = $connectDatabase->query("SELECT * FROM post");

$posts = $request->fetchAll();

?>
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
                            <a href="post.php?id=<?php echo $post['id']; ?>">Voir plus</a>
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
                <a href="post.php?id=<?php echo $post['id']; ?>">Voir les offres</a>
            </div>
        </div>





    <?php endforeach; ?>
</div>

<?php require_once 'parts/footer.php'; ?>