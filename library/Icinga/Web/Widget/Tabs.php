<?php
// {{{ICINGA_LICENSE_HEADER}}}
// {{{ICINGA_LICENSE_HEADER}}}

namespace Icinga\Web\Widget;

use Icinga\Exception\ProgrammingError;

/**
 * Navigation tab widget
 *
 * Useful if you want to create navigation tabs
 *
 * @copyright  Copyright (c) 2013 Icinga-Web Team <info@icinga.org>
 * @author     Icinga-Web Team <info@icinga.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @deprecated Because of HTML creation of PHP<
 */
class Tabs extends AbstractWidget
{
    /**
     * This is where single tabs added to this container will be stored
     *
     * @var array
     */
    protected $tabs = array();

    /**
     * The name of the currently activated tab
     *
     * @var string
     */
    protected $active;

    /**
     * Class name(s) going to be assigned to the &lt;ul&gt; element
     *
     * @var string
     */
    protected $tab_class = 'nav-tabs';

    /**
     * Activate the tab with the given name
     *
     * If another tab is currently active it will be deactivated
     *
     * @param  string $name Name of the tab going to be activated
     *
     * @throws ProgrammingError if given tab name doesn't exist
     *
     * @return self
     */
    public function activate($name)
    {
        if ($this->has($name)) {
            if ($this->active !== null) {
                $this->tabs[$this->active]->setActive(false);
            }
            $this->get($name)->setActive();
            $this->active = $name;
            return $this;
        }

        throw new ProgrammingError(
            sprintf(
                "Cannot activate a tab that doesn't exist: %s. Available: %s",
                $name,
                empty($this->tabs)
                ? 'none'
                : implode(', ', array_keys($this->tabs))
            )
        );
    }

    public function getActiveName()
    {
        return $this->active;
    }

    /**
     * Set the CSS class name(s) for the &lt;ul&gt; element
     *
     * @param  string $name CSS class name(s)
     *
     * @return self
     */
    public function setClass($name)
    {
        $this->tab_class = $name;
        return $this;
    }

    /**
     * Whether the given tab name exists
     *
     * @param  string $name Tab name
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->tabs);
    }

    /**
     * Whether the given tab name exists
     *
     * @param  string $name The tab you're interested in
     *
     * @throws ProgrammingError if given tab name doesn't exist
     *
     * @return Tab
     */
    public function get($name)
    {
        if (! $this->has($name)) {
            throw new ProgrammingError(
                sprintf(
                    'There is no such tab: %s',
                    $name
                )
            );
        }
        return $this->tabs[$name];
    }

    /**
     * Add a new tab
     *
     * A unique tab name is required, the Tab itself can either be an array
     * with tab properties or an instance of an existing Tab
     *
     * @param  string $name                The new tab name
     * @param  array|Tab The tab itself of it's properties
     *
     * @throws ProgrammingError if tab name already exists
     *
     * @return self
     */
    public function add($name, $tab)
    {
        if ($this->has($name)) {
            throw new ProgrammingError(
                sprintf(
                    'Cannot add a tab named "%s" twice"',
                    $name
                )
            );
        }
        return $this->set($name, $tab);
    }

    /**
     * Set a tab
     *
     * A unique tab name is required, will be replaced in case it already
     * exists. The tab can either be an array with tab properties or an instance
     * of an existing Tab
     *
     * @param  string $name                The new tab name
     * @param  array|Tab The tab itself of it's properties
     *
     * @return self
     */
    public function set($name, $tab)
    {
        if ($tab instanceof Tab) {
            $this->tabs[$name] = $tab;
        } else {
            $this->tabs[$name] = new Tab($tab + array('name' => $name));
        }
        return $this;
    }

    /**
     * This is where the tabs are going to be rendered
     *
     * @return string
     */
    public function renderAsHtml()
    {
        $view = $this->view();

        if (empty($this->tabs)) {
            return '';
        }
        $html = '<ul class="nav ' . $this->tab_class . '">' . "\n";

        foreach ($this->tabs as $tab) {
            $html .= $tab;
        }
        $html .= "</ul>\n";
        return $html;
    }
}
