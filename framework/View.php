<?php

namespace Framework;

class View
{
    /**
     * Data available to the view templates
     * @var array
     */
    private $data = array();

    /**
     * Path to templates base directory (without trailing slash)
     * @var string
     */
    protected $templatesDirectory;

    /**
     * Append data to view
     * @param  array $data
     * @throws \Exception
     */
    public function appendData($data)
    {
        if (!is_array($data)) {
            throw new \Exception('Cannot append view data. Expected array argument.');
        }

        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /********************************************************************************
     * Resolve template paths
     *******************************************************************************/

    /**
     * Set the base directory that contains view templates
     * @param   string $directory
     * @throws  \InvalidArgumentException If directory is not a directory
     */
    public function setTemplatesDirectory($directory)
    {
        $this->templatesDirectory = rtrim($directory, DIRECTORY_SEPARATOR);
    }

    /**
     * Get templates base directory
     * @return string
     */
    public function getTemplatesDirectory()
    {
        return $this->templatesDirectory;
    }

    /**
     * Get fully qualified path to template file using templates base directory
     * @param  string $file The template file pathname relative to templates base directory
     * @return string
     */
    public function getTemplatePathname($file)
    {
        return $this->templatesDirectory . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);
    }

    /********************************************************************************
     * Rendering
     *******************************************************************************/

    /**
     * Display template
     *
     * This method echoes the rendered template to the current output buffer
     *
     * @param  string   $template   Pathname of template file relative to templates directory
     * @param  array    $data       Any additonal data to be passed to the template.
     */
    public function display($template, $data = null)
    {
        echo $this->render($template, $data);
    }

    /**
     * Render a template file
     *
     * @param  string $template     The template pathname, relative to the template base directory
     * @param  array  $data         Any additonal data to be passed to the template.
     * @return string               The rendered template
     * @throws \Exception           If resolved template pathname is not a valid file
     */
    protected function render($template, $data = null)
    {
        $templatePathname = $this->getTemplatePathname($template);
        if (!is_file($templatePathname)) {
            throw new \Exception("View cannot render `$template` because the template does not exist");
        }

        $data = array_merge($this->data, (array) $data);
        extract($data);
        ob_start();
        require $templatePathname;

        return ob_get_clean();
    }
}
