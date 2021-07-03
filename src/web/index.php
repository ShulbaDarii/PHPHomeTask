<?php
require_once './functions.php';

$airports = require './airports.php';
$count=count($airports);
$page=1;
$sort='';
$state='';
$let='';
$pageMin=1;
$pageMax=10;
if(isset($_GET['filter_by_first_letter'])){
    $airports =array_filter($airports, function($a){
            return ($a['name'][0]  == $_GET['filter_by_first_letter']);
        });
    $let='&filter_by_first_letter='.$_GET['filter_by_first_letter'];
}
if(isset($_GET['sort_by'])){
    usort($airports, function($a, $b){
        return ($a[$_GET['sort_by']] > $b[$_GET['sort_by']]);
    });
    $sort='&sort_by='.$_GET['sort_by'];

}

if(isset($_GET['filter_by_state'])){
    $airports =array_filter($airports, function($a){
        return ($a['state']  == $_GET['filter_by_state']);
    });
    $state='&filter_by_state='.$_GET['filter_by_state'];
}

if(isset($_GET['page'])){
    $page=$_GET['page'];      
    if($page>=10){
        $pageMin=$page-5;
        $pageMax=$page+5;
    }
    $airports =array_chunk($airports, 5);
    $count=count($airports);
    if($pageMax>$count){
        $pageMax=$count;
    }
    
}
$url='index.php?page='.$page.$let . $sort . $state;
// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 */

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 */

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters(require './airports.php') as $letter): ?>
            <a href='?page=1&filter_by_first_letter=<?= $letter ?><?=$sort?><?=$state?>'  ><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="?page=1" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href='?page=1<?= $let ?>&sort_by=name<?=$state?>' >Name</a></th>
            <th scope="col"><a href='?page=1<?= $let ?>&sort_by=code<?=$state?>'>Code</a></th>
            <th scope="col"><a href='?page=1<?= $let ?>&sort_by=state<?=$state?>'>State</a></th>
            <th scope="col"><a href='?page=1<?= $let ?>&sort_by=city<?=$state?>'>City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php foreach ($airports[$page-1] as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href="index.php?page=1&<?= $let ?><?=$sort?>&filter_by_state=<?= $airport['state'] ?>"><?= $airport['state'] ?></a></td>
            <td><?= $airport['city'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php
                for ($i=$pageMin; $i < $pageMax+1; $i++) { 
                    if($i==$page){
                        echo '<li class="page-item active"><a class="page-link" href="index.php?page='.$i.$let.$sort.$state.'">'.$i. '</a></li>';
                    }else{
                        echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.$let.$sort.$state.'">'.$i  .'</a></li>';
                    }
                }
            ?>
        </ul>
    </nav>

</main>
</html>
