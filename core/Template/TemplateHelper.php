<?php
namespace Core\Template;

trait TemplateHelper
{
    private $_post_value;

    /**
     * Return All Post Request Value
     * @return bool
     */
    private function postsExists()
    {
        return isset($this->session->post_data);
    }

    /**
     * Get the post value and store in session
     * Isset the session after display the value for one time
     * @return string
     */
    public function old($value, $object = null)
    {
        $object_field = ucfirst($value);
        if ($this->postsExists()) {
            $this->_post_value = $this->session->post_data;
            return $this->_post_value[$value];
        }
        return isset($this->_post_value[$value]) ? $this->_post_value[$value] : (is_null($object) ? '' : $object->$object_field);
    }

    /**
    * Genrate the CSRF_TOKEN input and the id input
    * type hidden
    * @return string
    */
    public function csrf_token($id_value = null)
    {
        $input = '';
        if ($id_value !== null) {
            $input .= '<input type="hidden" name="csrf_token" value="'.CSRF_TOKEN.'"/>';
            $input .= '<input type="hidden" name="id" value="'.$id_value.'"/>';
        } else {
            $input .= '<input type="hidden" name="csrf_token" value="'.CSRF_TOKEN.'"/>';
        }
        return $input;
    }

    /**
    * Unset the sessions
    * will be echo in footer
    * @return mixed
    */
    public function unserFooter()
    {
        unset($this->session->errors);
        unset($this->session->post_data);
    }

    /**
     * [Echo the given url with app languge if session key lang_changed isset]
     * @param  string $url [the given url]
     * @return string      [the pepared url]
     */
    public function url($url)
    {
      $pepared_url = (isset($this->session->lang_changed) ? '/'.$this->session->app_langauge .'/'.$url : '/'. $url);
      return $pepared_url;
    }
}
