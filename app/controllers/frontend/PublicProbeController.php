<?php

class PublicProbeController extends BaseController {

	public function show($probeUrl){

		$probe = Probe::getProbeTemplate($probeUrl); 

		return View::make('frontend.probe.show')
					 ->with('probeId', $probe['id'])
					 ->with('probe', $probe); 

	}


}
