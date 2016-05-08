<?php
namespace models;

class Model
{
	public function send($status = null, $data = null)
	{
		//echo json_encode(array('status' => $status, 'data' => $data));
		$message = (isset($data['message']) && is_string($data['message'])) ? $data['message'] : ((is_string($data)) ? $data : "");

		if (!empty($message)) {
			echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
		}
	}
}