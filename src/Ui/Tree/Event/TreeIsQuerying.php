<?php namespace Anomaly\Streams\Platform\Ui\Tree\Event;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TreeIsQuerying
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Event
 */
class TreeIsQuerying
{

    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * The tree query.
     *
     * @var Builder
     */
    protected $query;

    /**
     * Create a new TreeIsQuerying instance.
     *
     * @param TreeBuilder $builder
     * @param Builder     $query
     */
    public function __construct(TreeBuilder $builder, Builder $query)
    {
        $this->builder = $builder;
        $this->query   = $query;
    }

    /**
     * Get the query.
     *
     * @return Builder
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get the tree.
     *
     * @return TreeBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
