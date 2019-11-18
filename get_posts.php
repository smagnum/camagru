<?php
require_once("inc/init.php");

    if (isset($_POST['limit_start']) && is_numeric($_POST['limit_start']))
    {
        $limit_start = $_POST['limit_start'];
        $select = $dbConnection->prepare("SELECT * FROM posts order by id_post desc LIMIT :limit_start, 5");
        $select->bindValue(':limit_start', (int) trim($limit_start), PDO::PARAM_INT);
        $select->execute();
        $ch = '';
            while ($res = $select->fetch())
            {
                $ch .= '<div class="postes">
                        <a href="post.php?post=' . $res["id_post"] . '" target="_blank"><img src="'. $res["image"] .'"/></a>
                    </div>';
            }
        echo $ch;
    }
    
?>