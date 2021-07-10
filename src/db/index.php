<?php

require_once './functions.php';
require_once './pdo_ini.php';

// $airports=require '../web/airports.php';
// $airports= array_chunk($airports, 5,true);

    if($_SERVER['REQUEST_METHOD']=='GET'){
    $page =isset($_GET['page']) ? $_GET['page'] : 1;
    $url_filter_by_state ='';
    $url_sort='';
    $url_filter_by_letter ='';
    $url_page ='';

    foreach($_GET as $key =>$value){
        $function_name=snakeCaseToCamelCase('get_' . $key);
        if(function_exists($function_name)){  
            $sql=$function_name($sql,$value);
            $url = 'url_' . $key;
            $$url = "&$key=$value";

        }
    }

    $res_query=getAirports($pdo,$sql);
    $airports = $res_query['airports'];
    $count_airports=$res_query['count'];


    if($page<10){
        $start_page=1;
        $end_page=(ceil($count_airports/5)>$page +5)? $page +5 :ceil($count_airports/5);
    }else{
        $start_page=$page-5;
        $end_page=(ceil($count_airports/5)>$page +5)? $page +5 :ceil($count_airports/5);
    }

}

/**
 * Connect to DB
 */

/**
 * SELECT the list of unique first letters using https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */
//$uniqueFirstLetters = ['A', 'B', 'C'];

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */

/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
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

        <?php foreach (getUniqueFirstLetters($pdo) as $letter): ?>
            <a href="./?filter_by_first_letter=<?= $letter . $url_filter_by_state . $url_sort ?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="./" class="float-right">Reset all filters</a>
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
            <th scope="col"><a href="./?sort=name&page=<?= $page . $url_filter_by_state . $url_filter_by_letter?>">Name</a></th>
            <th scope="col"><a href="./?sort=code&page=<?= $page . $url_filter_by_state . $url_filter_by_letter?>">Code</a></th>
            <th scope="col"><a href="./?sort=state&page=<?= $page . $url_filter_by_state . $url_filter_by_letter?>">State</a></th>
            <th scope="col"><a href="./?sort=city&page=<?= $page . $url_filter_by_state . $url_filter_by_letter?>">City</a></th>
            <th scope="col"><a href="./?sort=address&page=<?= $page . $url_filter_by_state . $url_filter_by_letter?>">Address</a></th>
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
        <?php foreach ($airports as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href="./?filter_by_state=<?=$airport['state'] .$url_filter_by_letter?>"><?= $airport['state'] ?></a></td>
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
                for ($i=$start_page; $i < $end_page+1; $i++) { 
                    if($i==$page){
                        echo '<li class="page-item active"><a class="page-link" href="index.php?page='.$i. $url_filter_by_letter . $url_filter_by_state .$url_sort.'">'.$i. '</a></li>';
                    }else{
                        echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.$url_filter_by_letter . $url_filter_by_state .$url_sort.'">'.$i  .'</a></li>';
                    }
                }
            ?>
        </ul>
    </nav>

</main>
</html>
