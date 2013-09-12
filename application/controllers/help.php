<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Help extends ImpulseController {

    public function __construct() {
        parent::__construct();
        $this->_addTrail("Help","#");
    }

    public function systems($topic) {

        $topic = rawurldecode($topic);

        // Trail
        $this->_addTrail("Systems", "#");
        $this->_addTrail(ucfirst($topic), "#");

        // Content
        $content = $this->load->view("help/systems/$topic",null,true);

        // Render
        $this->_render($content);
    }
    public function dns($topic) {

        $topic = rawurldecode($topic);

        // Trail
        $this->_addTrail("DNS", "#");
        $this->_addTrail(ucfirst($topic), "#");

        // Content
        $content = $this->load->view("help/dns/$topic",null,true);

        // Render
        $this->_render($content);
    }
    public function ip($topic) {

        $topic = rawurldecode($topic);

        // Trail
        $this->_addTrail("IP", "#");
        $this->_addTrail(ucfirst($topic), "#");

        // Content
        $content = $this->load->view("help/ip/$topic",null,true);

        // Render
        $this->_render($content);
    }
    public function dhcp($topic) {

        $topic = rawurldecode($topic);

        // Trail
        $this->_addTrail("DHCP", "#");
        $this->_addTrail(ucfirst($topic), "#");

        // Content
        $content = $this->load->view("help/dhcp/$topic",null,true);

        // Render
        $this->_render($content);
    }
    public function management($topic) {

        $topic = rawurldecode($topic);

        // Trail
        $this->_addTrail("Management", "#");
        $this->_addTrail(ucfirst($topic), "#");

        // Content
        $content = $this->load->view("help/management/$topic",null,true);

        // Render
        $this->_render($content);
    }
    public function network($topic) {

        $topic = rawurldecode($topic);

        // Trail
        $this->_addTrail("Network", "#");
        $this->_addTrail(ucfirst($topic), "#");

        // Content
        $content = $this->load->view("help/network/$topic",null,true);

        // Render
        $this->_render($content);
    }
    public function search() {

        // Trail
        $this->_addTrail("Search", "#");

        // Content
        $content = $this->load->view("help/search",null,true);

        // Render
        $this->_render($content);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
