<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 30/05/19
 * Time: 00:38
 */

include_once "utils/pathfinding/PqTsp.php";
include_once "utils/pathfinding/TspLocation.php";
include_once "utils/pathfinding/TspNode.php";

class TspBranchBound
{
    protected $n = 0;
    protected $locations = array();
    protected $costMatrix = array();

    /**
     * @var    array  TspBranchBound instances container.
     */
    protected static $instances = array();

    /**
     * Constructor
     */
    public function __construct($costMatrix = array())
    {
        if ($costMatrix) {
            $this->costMatrix = $costMatrix;
            $this->n = count($this->costMatrix);
        }
    }

    /**
     * Method to get an instance of a TspBranchBound.
     *
     * @param   string  $name     The name of the TspBranchBound.
     * @param   array   $locations  An array of locations.
     *
     * @return  object  TspBranchBound instance.
     *
     * @throws  Exception if an error occurs.
     */
    public static function getInstance($name = 'TspBranchBound', $locations = null)
    {
        // Reference to array with instances
        $instances = &self::$instances;

        // Only instantiate if it does not already exist.
        if (!isset($instances[$name]))
        {
            // Instantiate the TspBranchBound.
            $instances[$name] = new TspBranchBound();
        }

        $instances[$name]->locations = array();
        $instances[$name]->costMatrix = array();

        // Load the data.
        if ($locations)
        {
            if ($instances[$name]->load($locations) == false)
            {
                throw new RuntimeException('TspBranchBound::getInstance could not load locations');
            }
        }

        return $instances[$name];
    }

    public function load($locations)
    {
        if (empty($locations))
            return false;

        foreach ($locations as $location)
        {
            if (empty($location))
                return false;

            if ($this->addLocation($location) == false)
                return false;
        }

        return $this->loadMatrix();
    }

    public function loadMatrix()
    {
        if (empty($this->locations))
            return false;

        $this->costMatrix = array();
        $n_locations = count($this->locations);
        for ($i = 0; $i < $n_locations; $i++)
        {
            echo $i+1 . ". " . $this->locations[$i]->id . "\n";
            for ($j = 0; $j < $n_locations; $j++)
            {
                $distance = INF;
                if ($i!=$j)
                {
                    $loc1 = $this->locations[$i];
                    $loc2 = $this->locations[$j];
                    $distance = TspLocation::distance($loc1->latitude, $loc1->longitude, $loc2->latitude, $loc2->longitude);
                }
                $this->costMatrix[$i][$j] = $distance;
            }
        }

        $this->n = count($this->costMatrix);

        return true;
    }

    public function addLocation($location)
    {
        try
        {
            $location = TspLocation::getInstance($location);
        }
        catch (Exception $e)
        {
            return false;
        }

        $this->locations[] = $location;

        return true;
    }

    protected function buildCostMatrix () {
        $this->costMatrix = array();
        $n_locations = count($this->locations);
        $coordinates = "";
        for ($i = 0; $i < $n_locations; $i++) {
            if ($i == 0) {
                $coordinates = $coordinates. $this->locations[$i]->latitude . "," . $this->locations[$i]->longitude;
            } else {
                $coordinates = $coordinates . "|". $this->locations[$i]->latitude . "," . $this->locations[$i]->longitude;
            }



//            echo $i+1 . ". " . $this->locations[$i]->id . "\n";
//            for ($j = 0; $j < $n_locations; $j++)
//            {
//                $distance = INF;
//                if ($i!=$j)
//                {
//                    $loc1 = $this->locations[$i];
//                    $loc2 = $this->locations[$j];
//                    $distance = TspLocation::distance($loc1->latitude, $loc1->longitude, $loc2->latitude, $loc2->longitude);
//                }
//                $this->costMatrix[$i][$j] = $distance;
//            }
        }
        // api key for now
        $key ="AIzaSyAl0p7YX_rNrezTd_A4VOjvW0-cIKHbPo0";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".
                $coordinates . "&destinations=" . $coordinates . "&key=" . $key;
//            . "48.8223325,2.3611967&destinations=48.7716862,2.3267193&key=" .$key;
            $response = json_decode(CurlManager::getManager()->curlGet($url)["result"],true);

//        return CurlManager::getManager()->curlGet($url);
//        return $response['status'];
        if ($response['status'] == 'OK') {
            return $response['rows'][0]['elements'][0]['duration']['value'];
            for ($i = 0; $i <$n_locations; $i++) {
                for ($j = 0; $j < $n_locations; $j++) {
                    if ($i == $j) {
                        $this->costMatrix[$i][$j] = 0;
                    } else {
                        $this->costMatrix[$i][$j] = $response['rows'][$i]['elements'][$j]['duration']['value'];
                    }
                }
            }
        } else {
            return -1;
        }
    }

    protected function rowReduction(&$reducedMatrix, &$row)
    {
        // initialize row array to INF
        $row = array_fill(0, $this->n, INF);

        // row[i] contains minimum in row i
        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] < $row[$i])
                    $row[$i] = $reducedMatrix[$i][$j];

        // reduce the minimum value from each element in each row.
        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] !== INF && $row[$i] !== INF)
                    $reducedMatrix[$i][$j] -= $row[$i];
    }

    protected function columnReduction(&$reducedMatrix, &$col)
    {
        // initialize row array to INF
        $col = array_fill(0, $this->n, INF);

        // col[i] contains minimum in row i
        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] < $col[$j])
                    $col[$j] = $reducedMatrix[$i][$j];

        // reduce the minimum value from each element in each row.
        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->n; $j++)
                if ($reducedMatrix[$i][$j] !== INF && $col[$j] !== INF)
                    $reducedMatrix[$i][$j] -= $col[$j];
    }

    protected function calculateCost(&$reducedMatrix)
    {
        // initialize cost to 0
        $cost = 0;

        // Row Reduction
        $row = array();
        $this->rowReduction($reducedMatrix, $row);

        // Column Reduction
        $col = array();
        $this->columnReduction($reducedMatrix, $col);

        // the total expected cost
        // is the sum of all reductions
        for ($i = 0; $i < $this->n; $i++) {
            $cost += ($row[$i] !== INF) ? $row[$i] : 0;
            $cost += ($col[$i] !== INF) ? $col[$i] : 0;
        }

        return $cost;
    }

    public function printPath($list)
    {
        echo "\nPath: \n";
        for ($i = 0; $i < count($list); $i++) {
            $start = $list[$i][0] + 1;
            $end = $list[$i][1] + 1;
            echo $start . " -> " . $end . "\n";
        }
    }

    public function solve()
    {
        if (empty($this->costMatrix))
        {
            if (!$this->loadMatrix())
                return false;
        }

        $costMatrix = $this->costMatrix;
        // Create a priority queue to store live nodes of
        // search tree;
        $pq = new PqTsp();

        // create a root node and calculate its cost
        // The TSP starts from first city i.e. node 0
        $root = new TspNode($costMatrix, null, 0, -1, 0);
        // get the lower bound of the path starting at node 0
        $root->cost = $this->calculateCost($root->reducedMatrix);

        // Add root to list of live nodes;
        $pq->insert($root, $root->cost);

        // Finds a live node with least cost,
        // add its children to list of live nodes and
        // finally deletes it from the list.
        while($pq->valid())
        {
            // Find a live node with least estimated cost
            $min = $pq->extract();

            // Clear the max estimated nodes
            $pq = new PqTsp();

            // i stores current city number
            $i = $min->vertex;

            // if all cities are visited
            if ($min->level == $this->n - 1)
            {
                // return to starting city
                $min->path[] = array($i, 0);
                // print list of cities visited;
                $this->printPath($min->path);

                // return optimal cost & etc.
                return array ('cost' => $min->cost, 'path' => $min->path, 'locations' => $this->locations);
            }

            // do for each child of min
            // (i, j) forms an edge in space tree
            for ($j = 0; $j < $this->n; $j++)
            {
                if ($min->reducedMatrix[$i][$j] !== INF)
                {
                    // create a child node and calculate its cost
                    $child = new TspNode($min->reducedMatrix, $min->path, $min->level+1, $i, $j);

                    /* Cost of the child =
                        cost of parent node +
                        cost of the edge(i, j) +
                        lower bound of the path starting at node j
                    */
                    $child->cost = $min->cost + $min->reducedMatrix[$i][$j] + $this->calculateCost($child->reducedMatrix);

                    // Add child to list of live nodes
                    $pq->insert($child, $child->cost);
                }
            }

            // free node as we have already stored edges (i, j) in vector
            // So no need for parent node while printing solution.
            $min = null;
        }
    }
}