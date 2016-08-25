<?php
namespace YuzuruS\Redis;
/**
 * Recommend
 *
 * @author Yuzuru Suzuki <navitima@gmail.com>
 * @license MIT
 */
class Recommend
{
    /** @var mixed Redis instance */
    private $redis;

    /** @var string view key name for redis. */
    private $v_ns = '';

    /** @var string jaccard key name for redis. */
    private $j_ns = '';

    /** @var int number of recommend items */
    private $num_recommend_items;

    /**
     * __construct
     *
     * @access public
     * @param mixed redis(optional)
     * @param int $num_recommend_items(optional)
     * @param string $v_ns(optional)
     * @param string $j_ns(optional)
     * @return void
     */
    public function __construct($redis = null, $num_recommend_items = 500, $v_ns = 'Viewer:Item:', $j_ns = 'Jaccard:Item:')
    {
        if (!$redis) {
            $redis = new \Redis();
            $redis->pconnect('127.0.0.1', 6379);
        }
        $this->redis = $redis;
        $this->v_ns = $v_ns;
        $this->j_ns = $j_ns;
        $this->num_recommend_items = $num_recommend_items;
    }
    /**
     * setRating
     *
     * @param int $user_id
     * @param int $item_id
     * @access public
     * @return boolean
     */
    public function setRating($user_id, $item_id)
    {
        $this->redis->lRem($this->v_ns . $item_id, $user_id);
        $this->redis->lPush($this->v_ns . $item_id, $user_id);
        $this->redis->lTrim($this->v_ns . $item_id, 0, $this->num_recommend_items - 1);
        return true;
    }
    /**
     * calcJaccard
     *
     * @param int[] $all_item_ids
     * @access public
     * @return boolean
     */
    public function calcJaccard($all_item_ids)
    {
        foreach ($all_item_ids as $item_id1) {
            $base = $this->redis->lRange($this->v_ns . $item_id1, 0, $this->num_recommend_items - 1);
            if (count($base) === 0) {
                continue;
            }
            foreach ($all_item_ids as $item_id2) {
                if ($item_id1 === $item_id2) {
                    continue;
                }
                $target = $this->redis->lRange($this->v_ns . $item_id2, 0, $this->num_recommend_items - 1);
                if (count($target) === 0) {
                    continue;
                }

                # calculation of jaccard
                $join = floatval(count(array_unique(array_merge($base, $target))));
                $intersect = floatval(count(array_intersect($base, $target)));
                if ($intersect == 0 || $join == 0) {
                    continue;
                }
                $jaccard = $intersect / $join;

                $this->redis->zAdd($this->j_ns . $item_id1, $jaccard, $item_id2);
            }
        }
        return true;
    }
    /**
     * getItems
     *
     * @param int $item_id
     * @param int $num_recommended(optional)
     * @access public
     * @return int[]
     */
    public function getItems($item_id, $num_recommended = -1)
    {
        return $this->redis->zRevRange($this->j_ns . $item_id, 0, $num_recommended);
    }
}
