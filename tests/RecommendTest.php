<?php
require __DIR__ . '/../vendor/autoload.php';
/**
 * RecommendTest
 *
 * @version $id$
 * @copyright Yuzuru Suzuki
 * @author Yuzuru Suzuki <navitima@gmail.com>
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
use YuzuruS\Redis\Recommend;
class RecommendTest extends \PHPUnit_Framework_TestCase
{
    private $recommend;

    /**
     * Provider for rating
     *
     * @return array
     */
    public function ratingProvider()
    {
        return [
            [
                1, [1, 3, 5],
            ],
            [
                2, [2, 4, 5],
            ],
            [
                3, [2, 3, 4, 7],
            ],
            [
                4, [3],
            ],
            [
                5, [4, 6, 7],
            ],
        ];
    }
    /**
     * setUp
     *
     * @access public
     * @return void
     */
    public function setUp()
    {
        $this->recommend = new Recommend;
    }
    /**
     * @dataProvider ratingProvider
     */
    public function testSetRating($user_id, $item_ids)
    {
        foreach ($item_ids as $item_id) {
            $return = $this->recommend->setRating($user_id, $item_id);
            $this->assertTrue($return);
        }
    }
    /**
     * @depends testSetRating
     */
    public function testCalcJaccard()
    {
        $return = $this->recommend->calcJaccard([1,2,3,4,5,6,7]);
        $this->assertTrue($return);
    }
    /**
     * @depends testCalcJaccard
     */
    public function testGetItems()
    {
        $return = $this->recommend->getItems(1);
        $this->assertTrue(empty(array_diff([3,5], $return)));
    }
    public function tearDown()
    {
    }
}
