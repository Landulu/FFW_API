
<?php

include_once 'models/Address.php';
include_once 'utils/curl/CurlManager.php';


class CourseOptimiser {

    private $n = 4; 
  
    // final_path[] stores the final solution ie, the 
    // path of the salesman. 
    private $finalPath;
  
    // visited[] keeps track of the already visited nodes 
    // in a particular path 
    private $visited;
  
    // Stores the final minimum weight of shortest tour. 
    private $finalRes = PHP_INT_MAX;

    /**
     * CourseOptimiser constructor.
     */
    public function __construct()
    {
    }


    public function buildAdjMatrix($addresses) {
        $adj = [];

        for ($i = 0; $i < count($addresses); $i++) {
            for($j = 0; $j < count($addresses); $j++) {
                if ($j != $i) {
                    $cost = $this->getDistanceBetweenAddresses($addresses[$i], $addresses[$j]);
                    $adj[$i][$j] = $cost;
                }
            }
        }


    }

    public function getDistanceBetweenAddresses(
//        Address $addressA, Address $addressB
    ) {
        // api key for now
        $key ="AIzaSyAl0p7YX_rNrezTd_A4VOjvW0-cIKHbPo0";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins="
//            . $addressA->getLatitude() . "," . $addressA->getLongitude() . "&destinations=" . $addressB->getLatitude() . "," . $addressB->getLongitude() . "&key=" . $key;
            . "48.8223325,2.3611967&destinations=48.7716862,2.3267193&key=" .$key;
//        $response = json_decode(CurlManager::getManager()->curlGet($url));

          return CurlManager::getManager()->curlGet($url);
//        return $response->status;
//        if ($response->status == 'OK') {
//            return $response->rows[0]['elements'][0]['duration']['value'];
//        } else {
//            return -1;
//        }

    }

    
    public function getShortestPath($adj) { 
        $currPath[] = []; 
        $this->n = count($adj);
  
        // Calculate initial lower bound for the root node 
        // using the formula 1/2 * (sum of first min + 
        // second min) for all edges. 
        // Also initialize the currPath and visited array 
        $currBound = 0; 
        $currPath  = array_fill(0, $this->n + 1,  -1); 
        $this->visited = array_fill(0, $this->n, false); 
  
        // Compute initial bound 
        for ($i = 0; $i < $this->n; $i++) 
            $currBound += ($this->firstMin($adj, $i) +
                        $this->secondMin($adj, $i));
  
        // Rounding off the lower bound to an integer 
        $currBound = ($currBound==1)? $currBound/2 + 1 : 
                                    $currBound/2; 
  
        // We start at vertex 1 so the first vertex 
        // in curr_path[] is 0 
        $this->visited[0] = true; 
        $currPath[0] = 0; 
  
        // Call to TSPRec for curr_weight equal to 
        // 0 and level 1 
        $this->recursiveShortestPath($adj, $currBound, 0, 1, $currPath);
    } 

    // Function to find the minimum edge cost 
    // having an end at the vertex i 
    private function firstMin($adj, $i) { 
        $min = PHP_INT_MAX; 
        for ($k = 0; $k < $this->n; $k++) 
            if ($adj[$i][$k] < $min && $i != $k) 
                $min = $adj[$i][$k]; 
        return $min; 
    } 

    // function to find the second minimum edge cost 
    // having an end at the vertex i 
    private function secondMin($adj, $i){ 
        $first = PHP_INT_MAX; 
        $second = PHP_INT_MAX; 
        for ($j=0; $j<$this->n; $j++) 
        { 
            if ($i == $j) 
                continue; 
  
            if ($adj[$i][$j] <= $first) 
            { 
                $second = $first; 
                $first = $adj[$i][$j]; 
            } 
            else if ($adj[$i][$j] <= $second && 
                    $adj[$i][$j] != $first) 
                $second = $adj[$i][$j]; 
        } 
        return $second; 
    } 

    // function that takes as arguments: 
    // curr_bound -> lower bound of the root node 
    // curr_weight-> stores the weight of the path so far 
    // level-> current level while moving in the search 
    //       space tree 
    // curr_path[] -> where the solution is being stored which 
    //           would later be copied to final_path[] 
    private function recursiveShortestPath($adj, $currBound, $currWeight, 
                $level, $currPath) { 
        // base case is when we have reached level N which 
        // means we have covered all the nodes once 
        if ($level == $this->n) 
        { 
            // check if there is an edge from last vertex in 
            // path back to the first vertex 
            if ($adj[$currPath[$level - 1]][$currPath[0]] != 0) 
            { 
                // curr_res has the total weight of the 
                // solution we got 
                $currRes = $currWeight + 
                        $adj[$currPath[$level - 1]][$currPath[0]];

                // Update final result and final path if 
                // current result is better. 
                if ($currRes < $this->finalRes)
                {
                    $this->copyToFinal($currPath);
                    $this->finalRes = $currRes; 
                } 
            } 
            return; 
        } 
  
        // for any other level iterate for all vertices to 
        // build the search space tree recursively 
        for ($i = 0; $i < $this->n; $i++) { 
            // Consider next vertex if it is not same (diagonal 
            // entry in adjacency matrix and not visited 
            // already) 
            if ($adj[$currPath[$level-1]][$i] != 0 && 
                    $this->visited[$i] == false) 
            { 
                $temp = $currBound; 
                $currWeight += $adj[$currPath[$level - 1]][$i]; 
  
                // different computation of curr_bound for 
                // level 2 from the other levels 
                if ($level==1) 
                $currBound -= (($this->firstMin($adj, $currPath[$level - 1]) + $this->firstMin($adj, $i))/2);
                else
                $currBound -= (($this->secondMin($adj, $currPath[$level - 1]) +
                        $this->firstMin($adj, $i))/2);
  
                // $currBound + curr_weight is the actual lower bound 
                // for the node that we have arrived on 
                // If current lower bound < final_res, we need to explore 
                // the node further 
                if ($currBound + $currWeight < $this->finalRes) 
                { 
                    $currPath[$level] = $i; 
                    $this->visited[$i] = true; 
  
                    // call TSPRec for the next level 
                    $this->recursiveShortestPath($adj, $currBound, $currWeight, $level + 1,
                        $currPath); 
                } 
  
                // Else we have to prune the node by resetting 
                // all changes to curr_weight and curr_bound 
                $currWeight -= $adj[$currPath[$level-1]][$i]; 
                $currBound = $temp; 
  
                // Also reset visited array 
                $this->visited = array_fill( 0, count($this->visited), false); 
                for ($j = 0; $j <= $level - 1; $j++) 
                    $this->visited[$currPath[$j]] = true;
            } 
        } 
    } 




    /// OLD // SACHA ET CELIA JE GARDE CA ICI AU CAS OU
    // NE PAS SUPPRIMER!!!

    // public function getFastestTour($stepsId, $globalMatrix) {

    //     if (sizeof($stepsId) !== sizeof($globalMatrix)) {
    //         echo " paramètres non conformes";
    //     }

    //     $linesReductionCost = 0;
    //     $addCost = $this->getLinesReductionCost($globalMatrix);
    //     if ($addCost !== 0) {
    //         $linesReductionCost += $addCost;
    //         $this->reduceMatrixLines($globalMatrix);
    //     }


    //     $columnsReductionCost = 0;
    //     $addCost = $this->getColumnsReductionCost($globalMatrix);
    //     if ($addCost !== 0) {
    //         $columnsReductionCost += $addCost;
    //         $this->reduceMatrixColumns($globalMatrix);
    //     }


    //     $totalReductionCost = $linesReductionCost + $columnsReductionCost;

    // }

    // private function getLinesReductionCost($matrix) {
    //     $totalReduction = 0;
    //     for ($i=0; $i < sizeof($matrix); $i++) { 
    //         $index = 0;
    //         $smallest = $matrix[$i][0];
    //         for ($j=0; $j < sizeof($matrix[$i]); $j++) { 
    //             if ($matrix[$i][$j] >= 0 && $matrix[$i][$j] < $smallest) {
    //                 $index = $j;
    //                 $smallest = $matrix[$i][$j];
    //             }
    //         }
    //         $totalReduction += $smallest;
    //     }
    //     return $totalReduction;
    // }

    // private function getColumnsReductionCost($matrix) {
    //     $totalReduction = 0;
    //     for ($i=0; $i < sizeof($matrix); $i++) { 
    //         $index = 0;
    //         $smallest = $matrix[0][$i];
    //         for ($j=0; $j < sizeof($matrix[$i]); $j++) { 
    //             if ($matrix[$j][$i] >= 0 && $matrix[$j][$i] < $smallest) {
    //                 $index = $i;
    //                 $smallest = $matrix[$j][$i];
    //             }
    //         }
    //         $totalReduction += $smallest;
    //     }
    //     return $totalReduction;
    // }

    // private function reduceMatrixLines(& $matrix) {
    //     for ($i=0; $i < sizeof($matrix); $i++) { 
    //         $index = 0;
    //         $smallest = $matrix[$i][0];
    //         for ($j=0; $j < sizeof($matrix[$i]); $j++) { 
    //             if ($matrix[$i][$j] >= 0 && $matrix[$i][$j] < $smallest) {
    //                 $index = $j;
    //                 $smallest = $matrix[$i][$j];
    //             }
    //         }
    //         for ($i=0; $i < sizeof($matrix[$i]); $i++) { 
    //             if ($matrix[$i][$j] > 0) {
    //                 $matrix[$i][$j] -= $smallest;
    //             }
    //         }
    //     }
    // }

    // private function reduceMatrixColulns(& $matrix) {
    //     for ($i=0; $i < sizeof($matrix); $i++) { 
    //         $smallest = $matrix[0][$i];
    //         for ($j=0; $j < sizeof($matrix[$i]); $j++) { 
    //             if ($matrix[$j][$i] >= 0 && $matrix[$j][$i] < $smallest) {
    //                 $smallest = $matrix[$j][$i];
    //             }
    //         }
    //         for ($i=0; $i < sizeof($matrix[$i]); $i++) { 
    //             if ($matrix[$j][$i] > 0) {
    //                 $matrix[$j][$i] -= $smallest;
    //             }
    //         }
    //     }
    // }





}
