<?php
// {{{ICINGA_LICENSE_HEADER}}}
// {{{ICINGA_LICENSE_HEADER}}}

namespace Icinga\Web\Paginator\Adapter;

/**
 * @see Zend_Paginator_Adapter_Interface
 */

class QueryAdapter implements \Zend_Paginator_Adapter_Interface
{
    /**
     * Array
     * 
     * @var array
     */
    protected $query = null;

    /**
     * Item count
     *
     * @var integer
     */
    protected $count = null;

    /**
     * Constructor.
     * 
     * @param array $query Query to paginate
     */
    // TODO: Re-add abstract Query type as soon as a more generic one
    //       is available. Should fit Protocol-Queries too.
    // public function __construct(\Icinga\Backend\Query $query)
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  integer $offset Page offset
     * @param  integer $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->query->limit($itemCountPerPage, $offset)->fetchAll();
    }

    /**
     * Returns the total number of items in the query result.
     *
     * @return integer
     */
    public function count()
    {
        if ($this->count === null) {
            $this->count = $this->query->count();
        }
        return $this->count;
    }
}
