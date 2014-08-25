<?php
/**
 * Created by PhpStorm.
 * User: Baptiste
 * Date: 21/08/14
 * Time: 16:12
 */

namespace Application\Paginator\Adapter;

/**
 * Interface ApigilityAdapterInterface
 * @package Application\Paginator\Adapter
 *
 * @deprecated
 */
interface ApigilityAdapterInterface {

	public function getAll($page, $size);
}