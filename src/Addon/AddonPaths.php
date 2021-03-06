<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;

/**
 * Class AddonPaths
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonPaths
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new AddonPaths instance.
     *
     * @param Application $application
     * @param Repository  $config
     */
    function __construct(Application $application, Repository $config)
    {
        $this->config      = $config;
        $this->application = $application;
    }


    /**
     * Return all addon paths in a given folder.
     *
     * @return array
     */
    public function all()
    {
        $eager    = $this->eager();
        $deferred = $this->deferred();

        $core        = $this->core() ?: [];
        $shared      = $this->shared() ?: [];
        $application = $this->application() ?: [];

        // Testing only addons.
        $testing = $this->testing() ?: [];

        // Other configured addons.
        $configured = $this->configured() ?: [];

        /**
         * Merge the eager and deferred
         * onto the front and back of
         * the paths respectively.
         */
        return array_unique(
            array_merge(
                $eager,
                array_reverse(
                    array_unique(
                        array_reverse(
                            array_merge(
                                array_filter(
                                    array_merge($core, $shared, $application, $configured, $testing)
                                ),
                                $deferred
                            )
                        )
                    )
                )
            )
        );
    }

    /**
     * Return paths to eager loaded addons.
     *
     * @return array
     */
    protected function eager()
    {
        return array_map(
            function ($path) {
                return base_path($path);
            },
            $this->config->get('streams::addons.eager', [])
        );
    }

    /**
     * Return paths to deferred addons.
     *
     * @return array
     */
    protected function deferred()
    {
        return array_map(
            function ($path) {
                return base_path($path);
            },
            $this->config->get('streams::addons.deferred', [])
        );
    }

    /**
     * Return all core addon paths in a given folder.
     *
     * @return bool
     */
    public function core()
    {
        $path = base_path('core');

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(glob("{$path}/*", GLOB_ONLYDIR));
    }

    /**
     * Return vendor addons of a given type.
     *
     * @param $directories
     * @return array
     */
    protected function vendorAddons($directories)
    {
        $paths = [];

        foreach ($directories as $vendor) {
            foreach (glob("{$vendor}/*", GLOB_ONLYDIR) as $addon) {
                $paths[] = $addon;
            }
        }

        return $paths;
    }

    /**
     * Return all shared addon paths in a given folder.
     *
     * @return bool
     */
    public function shared()
    {
        $path = base_path('addons/shared');

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(glob("{$path}/*", GLOB_ONLYDIR));
    }

    /**
     * Return all application addon paths in a given folder.
     *
     * @return bool
     */
    public function application()
    {
        $path = base_path('addons/' . $this->application->getReference());

        if (!is_dir($path)) {

            return false;
        }

        return $this->vendorAddons(glob("{$path}/*", GLOB_ONLYDIR));
    }

    /**
     * Return paths to testing only addons.
     *
     * @return array|bool
     */
    protected function testing()
    {
        $path = base_path('vendor/anomaly/streams-platform/addons');

        if (!is_dir($path) || env('APP_ENV') !== 'testing') {
            return false;
        }

        return $this->vendorAddons(glob("{$path}/*", GLOB_ONLYDIR));
    }

    /**
     * Return paths to configured addons.
     *
     * @return array|bool
     */
    protected function configured()
    {
        return array_map(
            function ($path) {
                return base_path($path);
            },
            $this->config->get('streams::addons.paths', [])
        );
    }
}
