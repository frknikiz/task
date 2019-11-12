<?php
/**
 * Created by frkn.
 * User: Furkan İKİZ
 * Date: 12.11.2019
 * Time: 17:50
 */

namespace App\Utils;

class QuickSorter
{

    private $arr;
    private $orderItems = [];

    public function __construct(array $arr)
    {
        $this->arr = $arr;
    }

    public function sortBy(string $key, array $transform = [])
    {
        $this->orderItems[] = ["key" => $key, "transform" => $transform];
        return $this;
    }

    private function quick_sort($array, $orderItems)
    {
        $loe = $gt = array();
        if (count($array) < 2) {
            return $array;
        }

        $pivot_key = key($array);
        $pivot = array_shift($array);
        foreach ($array as $val) {

            foreach ($this->orderItems as $orderItem) {

                if (count($orderItem["transform"]) > 0) {
                    $a = $this->transform($val[$orderItem["key"]], $orderItem["transform"]);
                    $b = $this->transform($pivot[$orderItem["key"]], $orderItem["transform"]);
                } else {
                    $a = $val[$orderItem["key"]];
                    $b = $pivot[$orderItem["key"]];
                }

                $compareVal = $this->compare($a, $b);
                if ($compareVal < 0) {
                    $loe[] = $val;
                    break;
                } elseif ($compareVal > 0) {
                    $gt[] = $val;
                    break;
                }
                if (end($this->orderItems) === $orderItem) {
                    $loe[] = $val;
                }
            }
        }

        return array_merge($this->quick_sort($loe, $orderItems), array($pivot_key => $pivot), $this->quick_sort($gt, $orderItems));
    }

    public function toArray()
    {
        if (count($this->orderItems) == 0) {
            return $this->arr;
        }
        return $this->quick_sort($this->arr, $this->orderItems);
    }

    private function transform($key, array $transform)
    {
        return $transform[$key];
    }

    private function compare($a, $b)
    {
        if (is_string($a)) {
            return strnatcmp($a, $b);
        } elseif ($a < $b) {
            return -1;
        } elseif ($a > $b) {
            return 1;
        }
        return 0;
    }


}
