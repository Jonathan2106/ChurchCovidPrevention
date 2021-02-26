<?php
class Events extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('events_model');
        $this->load->helper('url_helper');

        date_default_timezone_set('Asia/Taipei');
    }

    public function index()
    {
        $data['events'] = $this->events_model->get_events();
        $data['title'] = 'Events';

        $this->load->view('templates/header', $data);
        $this->load->view('events/index', $data);
        $this->load->view('templates/footer');
    }

    public function new_event()
    {
        $this->load->helper('form');

        $data['title'] = 'New Event';

        $this->load->view('templates/header', $data);
        $this->load->view('events/new_event', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->events_model->new_event();
        redirect('/events');
    }

    public function view($slug = NULL)
    {
        $data['event_item'] = $this->events_model->get_event_by_id($slug);
        $data['event_participant'] = $this->events_model->get_participant_by_event_id($slug);

        if (empty($data['event_item']))
        {
                show_404();
        }

        $data['title'] = $data['event_item']['event_name'];

        $this->load->view('templates/header', $data);
        $this->load->view('events/view_event', $data);
        $this->load->view('templates/footer');
    }

    public function add_participant_to_event($eventid)
    {
        $this->load->helper('form');
        $data['title'] = 'Add Participant';
        $data['events_item'] = $this->events_model->get_event_by_id($eventid);

        $this->load->view('templates/header', $data);
        $this->load->view('events/add_participant', $data);
        $this->load->view('templates/footer');
    }

    public function add_committee_to_event($eventid)
    {
        $this->load->helper('form');
        $data['title'] = 'Add Committee';
        $data['events_item'] = $this->events_model->get_event_by_id($eventid);

        $this->load->view('templates/header', $data);
        $this->load->view('events/add_committee', $data);
        $this->load->view('templates/footer');
    }

    public function phpinfo()
    {   
        $data['title'] = 'phpinfo';
        $this->load->view('templates/header', $data);
        $this->load->view('events/phpinfo');
    }

    public function process_add_participant_to_event()
    {
        $event_id = $this->input->post('event_id');
        //$this->load->view('events/phpinfo');
        echo $event_id;
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->events_model->add_participant();
        redirect('/manage/' . $event_id);
    }

    public function process_add_committee_to_event()
    {
        $event_id = $this->input->post('event_id');
        //$this->load->view('events/phpinfo');
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->events_model->add_committee();
        redirect('/manage/'.$event_id);
    }

    public function process_attend($eventid, $participantid)
    {
        $this->events_model->process_participant_attend($participantid);
        redirect('/events/'.$eventid);
    }

    public function onsite($eventid)
    {
        //$this->events_model->process_participant_attend($participantid);
        //redirect('/events/'.$eventid);

        $this->load->helper('form');
        $data['title'] = 'On Site';
        $data['event_item'] = $this->events_model->get_event_by_id($eventid);

        $this->load->view('templates/header', $data);
        $this->load->view('events/on_site', $data);
        $this->load->view('templates/footer');
    }

    public function onsite_reg($eventid){
        $this->events_model->onsite_process($eventid);


        $data['event_item'] = $this->events_model->get_event_by_id($eventid);

        $this->load->view('templates/header', $data);
        $this->load->view('events/thankyou', $data);
        $this->load->view('templates/footer');
    }

    public function summary($eventid){
        $data['event_item'] = $this->events_model->get_event_by_id($eventid);
        $data['event_participant'] = $this->events_model->get_participant_by_event_id($eventid);
		$onsite = 0;
		$participant = 0;
        $attended_participant = 0;
        $committee = 0;
		foreach ($data['event_participant']->result() as $row){
			$participant++;
            
            if ($row->participant_arrival != NULL){
                $attended_participant++;
                if($row->participant_committee == 1){
                    $committee++;
                }
			}
			if ($row->participant_onsite == 1){
				$onsite++;
            }
                
		}

		$data['participant'] = $participant;
		$data['attended_participant'] = $attended_participant;
        $data['onsite'] = $onsite;
        $data['committee'] = $committee;

        $data['title'] = $data['event_item']['event_name'];

        $this->load->view('templates/header', $data);
        $this->load->view('events/summary', $data);
        $this->load->view('templates/footer');
    }

    public function manage($eventid){
        $data['event_item'] = $this->events_model->get_event_by_id($eventid);
        $data['event_participant'] = $this->events_model->get_participant_by_event_id($eventid);
		$onsite = 0;
		$participant = 0;
        $attended_participant = 0;
        $committee = 0;
		foreach ($data['event_participant']->result() as $row){
			$participant++;
            
            if ($row->participant_arrival != NULL){
                $attended_participant++;
                if($row->participant_committee == 1){
                    $committee++;
                }
			}
			if ($row->participant_onsite == 1){
				$onsite++;
            }
                
		}

		$data['participant'] = $participant;
		$data['attended_participant'] = $attended_participant;
        $data['onsite'] = $onsite;
        $data['committee'] = $committee;

        $data['title'] = $data['event_item']['event_name'];

        $this->load->view('templates/header', $data);
        $this->load->view('events/manage', $data);
        $this->load->view('templates/footer');
    }

	public function hide($eventid){
		$this->events_model->hide_event($eventid);

		redirect('/events');
	}
}
