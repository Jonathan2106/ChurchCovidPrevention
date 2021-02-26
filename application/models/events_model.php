<?php
class Events_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_events()
    {

        $query = $this->db->get_where('event', array('event_active' => 1));
        return $query->result_array();
    }

    public function new_event()
    {
        date_default_timezone_set('Asia/Taipei');
        $this->load->helper('url');
        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'event_name' => $this->input->post('event_name'),
            'event_date' => $this->input->post('event_date'),
            'event_start' => $this->input->post('event_start'),
            'event_end' =>  $this->input->post('event_end')
        );

        return $this->db->insert('event', $data);
    }

    public function event_info()
    {
        $event_info = $this->db->get_where();
    }

    public function get_event_by_id($slug = FALSE)
    {
        $query = $this->db->get_where('event', array('event_id' => $slug));
        return $query->row_array();
    }

    public function get_participant_by_event_id($slug)
    {
        $query = $this->db->get_where('participant', array('event_id' => $slug));
        return $query;
    }

    public function add_participant()
    {
        date_default_timezone_set('Asia/Taipei');
        $data = array();

        $data_len = count($this->input->post('participants'));
        $event_id = $this->input->post('event_id');
        $time = $time = date("Y-m-d H:i:s", time());
        $arrival_null = NULL;
        $onsite_false = FALSE;

        foreach($this->input->post('participants') as $participant)
        {
            array_push($data, array(
                    'participant_name' => $participant['name'],
                    'event_id' => $event_id,
                    'participant_email' => $participant['email'], 
                    'participant_arrival' => $arrival_null,
                    'participant_onsite' => $onsite_false,
                    'participant_create' => $time)
            );
        }

        return $this->db->insert_batch('participant', $data);
    }

    public function add_committee()
    {
        date_default_timezone_set('Asia/Taipei');
        $data = array();

        $data_len = count($this->input->post('participants'));
        $event_id = $this->input->post('event_id');
        $time = $time = date("Y-m-d H:i:s", time());
        $arrival_null = NULL;
        $onsite_false = FALSE;

        foreach($this->input->post('participants') as $participant)
        {
            array_push($data, array(
                    'participant_name' => $participant['name'],
                    'event_id' => $event_id,
                    'participant_email' => $participant['email'], 
                    'participant_arrival' => $arrival_null,
                    'participant_onsite' => $onsite_false,
                    'participant_create' => $time,
                    'participant_committee' => 1)
            );
        }

        return $this->db->insert_batch('participant', $data);
    }

    public function process_participant_attend($participantid)
    {
        date_default_timezone_set('Asia/Taipei');
        $time = date("Y-m-d H:i:s", time());
        $data = array(
            'participant_arrival' => $time
        );

        return $this->db->update('participant', $data, array('participant_id' => $participantid));
    }   

    public function onsite_process($event_id){

        $time = date("Y-m-d H:i:s", time());
        $onsite_true = TRUE;
        $data =  array(
            'participant_name' => $this->input->post('participant_name'),
            'event_id' => $event_id,
            'participant_email' => $this->input->post('participant_email'), 
            'participant_arrival' => $time,
            'participant_onsite' => $onsite_true,
            'participant_create' => $time
        );

        return $this->db->insert('participant', $data);
    }

	public function hide_event($event_id){
		return $this->db->update('event', array('event_active' => 0), array('event_id' => $event_id));
	}
}
