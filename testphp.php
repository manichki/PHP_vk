function dijkstra($graph, $start, $end) {
    $rows = count($graph);
    $cols = count($graph[0]);
    $dist = array_fill(0, $rows, array_fill(0, $cols, INF));
    $visited = array_fill(0, $rows, array_fill(0, $cols, false));
    $dist[$start[0]][$start[1]] = 0;
    $heap = array();
    array_push($heap, array(0, $start));

    while (!empty($heap)) {
        list($d, $v) = array_shift($heap);
        if ($visited[$v[0]][$v[1]]) {
            continue;
        }
        $visited[$v[0]][$v[1]] = true;
        if ($v == $end) {
            break;
        }

        $dx = array(0, 1, 0, -1);
        $dy = array(1, 0, -1, 0);
        for ($i = 0; $i < 4; $i++) {
            $x = $v[0] + $dx[$i];
            $y = $v[1] + $dy[$i];
            if (0 <= $x && $x < $rows && 0 <= $y && $y < $cols && !$visited[$x][$y]) {
                $weight = $graph[$x][$y];
                if ($weight > 0) {
                    $distance = $dist[$v[0]][$v[1]] + $weight;
                    if ($distance < $dist[$x][$y]) {
                        $dist[$x][$y] = $distance;
                        array_push($heap, array($distance, array($x, $y)));
                    }
                }
            }
        }
        usort($heap, function($a, $b) {
            return $a[0] - $b[0];
        });
    }

    $path = array();
    if ($visited[$end[0]][$end[1]]) {
        $v = $end;
        while ($v != $start) {
            array_push($path, $v);
            $min_dist = INF;
            for ($i = 0; $i < 4; $i++) {
                $x = $v[0] + $dx[$i];
                $y = $v[1] + $dy[$i];
                if (0 <= $x && $x < $rows && 0 <= $y && $y < $cols && $visited[$x][$y]) {
                    if ($dist[$x][$y] < $min_dist) {
                        $min_dist = $dist[$x][$y];
                        $prev = array($x, $y);
                    }
                }
            }
            $v = $prev;
        }
        array_push($path, $start);
        return array_reverse($path);
    } else {
        return null;
    }
}