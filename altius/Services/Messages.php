<?php namespace Altius\Services;

class Messages {

	
	protected $messages=[];

	protected $group='default';

	protected $current=null;

	public function __construct() {
		$this->messages=collect(session('flash_messages',[]));

		$this->loadTemplates();


	}

	public function group($g) {
		$this->group=$g;
		return $this;
	}

	public function success(...$m) { $this->set('success',sprintf(...$m));}
	public function error(...$m)	{ $this->set('error',sprintf(...$m));}
	public function warning(...$m) { $this->set('warning',sprintf(...$m));}
	public function info(...$m)	{ $this->set('info',sprintf(...$m));}


	public function showAll($template='alert',$glue=' ') {
		return $this->render($this->filtered(),$template,$glue);
	}

	public function show($type,$template='alert',$glue=' ') {
		return $this->render(	$this->filtered($type),
								$template,
								$glue);
	}

	protected function filtered($type=null) {
		$messages=$this->messages->where('group',$this->group);
		if($type)
			$messages=$messages->where('type',$type);
		return $messages;

	}
	public function toArray($type=null) {
		return $this->filtered($type)->toArray();

	}
	public function count($type=null) {
		return $this->filtered($type)->count();
	}
	protected function set($type,$message) {
      
        $this->messages[]=  [ 
						'type' => $type,
						'message'	=> $message,
						'group' => $this->group,
			];
		request()->session()->flash('flash_messages',$this->messages);
	}

    protected function render($messages,$template,$glue=' ') {
        // delete flash

        request()->session()->flash('flash_messages',[]);

		$template = $this->templates[$template] ?: $template;

		$ret=[];
		foreach($messages as $m) {
			$ret[] =$this->parse($m,$template);
		}
		return implode($glue,$ret);

	}
	protected function parse($message,$template) {

		$ret=is_array($template) ? $template[$message['type']]:$template;
		foreach($message as $k => $v) {
			$ret=str_replace(':'.$k,$v,$ret);
			$ret=str_replace('!'.$k,json_encode($v),$ret);
		}
		return $ret;
	}
	protected $styles = ['alert'];
	protected function loadTemplates(){
		$dir = realpath(__DIR__ . '/../../resources/views/messages');
		$this->temmplates=[];
		foreach($this->styles as $s)
			foreach(['info','success','warning','error'] as $t)
				$this->templates[$s][$t] =  file_get_contents("$dir/$s/$t.blade.php");
			


	}
// info/success/warning/error
	protected $templates = [
			'alert' => 
				[
					'info'=>'
						<div class="rounded-md bg-blue-50 p-4">
						<div class="flex">
						<div class="flex-shrink-0">
							<!-- Heroicon name: solid/information-circle -->
							<svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
							</svg>
						</div>
						<div class="ml-3 flex-1 md:flex md:justify-between">
							<p class="text-sm text-blue-700">
							:message
							</p>
						</div>
						</div>
						</div>',
					'success' =>'
					<div class="rounded-md bg-green-50 p-4">
					<div class="flex">
					<div class="flex-shrink-0">
						<!-- Heroicon name: solid/information-circle -->
						<svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
					  </svg>
					</div>
					<div class="ml-3 flex-1 md:flex md:justify-between">
						<p class="text-sm text-green-700">
						:message
						</p>
					</div>
					</div>
					</div>',
					'warning' =>'
					<div class="rounded-md bg-yellow-50 p-4">
					<div class="flex">
					<div class="flex-shrink-0">
						<svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
						<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
				  		</svg>
				  	</div>
					<div class="ml-3 flex-1 md:flex md:justify-between">
						<p class="text-sm text-yellow-700">
						:message
						</p>
					</div>
					</div>
					</div>',
					'error' =>'
					<div class="rounded-md bg-red-50 p-4">
					<div class="flex">
					<div class="flex-shrink-0">
						<!-- Heroicon name: solid/information-circle -->
						<svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
					  </svg>
					</div>
					<div class="ml-3 flex-1 md:flex md:justify-between">
						<p class="text-sm text-red-700">
						:message
						</p>
					</div>
					</div>
					</div>',
				
				

				]


		];
}


