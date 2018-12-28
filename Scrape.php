<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 2018-12-28
 * Time: 11:06
 */

class Scrape
{
    public function getWebsiteContent()
    {
        $url = "https://hiverhq.com";
        $webContent = file_get_contents($url);
        file_put_contents("hiver.html", $this->clean($webContent));
    }

    private function clean($string)
    {
        $string = strip_tags($string);
        $tagsToDelete = array("head", "script", "style");
        $string = preg_replace('#<(' . implode('|', $tagsToDelete) . ')(?:[^>]+)?>.*?</\1>#s', '', $string);
        $string = preg_replace('/[^A-Za-z0-9\- ]/', '', $string);
        return preg_replace('/\n/', ' ', $string);
    }

}

class ListNode
{
    public $data;
    public $count;
    public $next;

    function __construct($data)
    {
        $this->data = $data;
        $this->count = 1;
        $this->next = NULL;
        $this->prev = NULL;
    }

    function readNode()
    {
        return $this->data;
    }
}

class LinkList
{
    private $firstNode;
    private $lastNode;
    private $count;

    function __construct()
    {
        $this->firstNode = NULL;
        $this->lastNode = NULL;
        $this->count = 0;
    }

    //insertion at the start of linklist
    public function insertAndSort($data)
    {
        $existingNode = $this->searchNode($data);
        if (!empty($existingNode)) {
            $existingNode->count++;
            $prevNode = $existingNode->prev;
            if (!empty($prevNode)) {
                while ($prevNode != null && $prevNode->count < $existingNode->count) {
                    $existingNext = $existingNode->next;
                    $prevPrev = $prevNode->prev;

                    $existingNode->next = $prevNode;
                    $existingNode->prev = $prevPrev;
                    if (!empty($prevPrev))
                        $prevPrev->next = $existingNode;
                    else
                        $this->firstNode = $existingNode;

                    $prevNode->prev = $existingNode;
                    if (!empty($existingNext)) {
                        $prevNode->next = $existingNext;
                        $existingNext->prev = $prevNode;
                    }
                    $prevNode = $existingNode->prev;
                }
            }
        } else {
            $link = new ListNode($data);
            $link->next = null;
            $link->prev = $this->lastNode;
            if ($link->prev != null) {
                $link->prev->next = $link;
            } else {
                $this->firstNode = $link;
            }
            $this->lastNode = &$link;
            $this->count++;
        }
    }

    //displaying all nodes of linklist
    public function readList()
    {
        $listData = array();
        $current = $this->lastNode;
        while ($current != NULL) {
            array_push($listData, $current->readNode());
            $current = $current->prev;
        }
        foreach ($listData as $v) {
            echo $v . " ";
        }
    }

    public function readListWithCount()
    {
        $listData = array();
        $current = $this->firstNode;
        $i = 0;
        while ($current != NULL && $i < 5) {
            echo $current->data . ":" . $current->count . PHP_EOL;
            $current = $current->next;
            $i++;
        }
        foreach ($listData as $v) {
            echo $v . " ";
        }
    }

    /**
     * @param $key
     * @return null|ListNode
     */
    public function searchNode($key)
    {
        $current = $this->lastNode;
        while ($current != NULL) {
            if ($current->readNode() == $key) {
                return $current;
            }
            $current = $current->prev;
        }
        return null;
    }
}


$s = new Scrape();
//$s->getWebsiteContent();
$fileContent = file_get_contents("hiver.html");
$words = explode(' ', $fileContent);
$obj = new LinkList();
foreach ($words as $word) {
    if (!empty($word))
        $obj->insertAndSort($word);
}

$obj->readListWithCount();