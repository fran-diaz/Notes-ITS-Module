<?php

class notes extends base_component implements components_interface {

	public function make_notes() : string {
		$html = '';

		if( isset( $_REQUEST['d'] ) ) { // Es el detalle de una línea de tabla
			$data = decode( $_REQUEST['d'] );
		} else {
			$data = [
				'table' => 'reports',
				'id' => $this -> component_info['reports_id'],
				'dsn' => $this -> _ITEC -> info()['dsn']
			];
		}
		?>

		<div class="h-100 p-3 d-flex flex-column-reverse flex-grow-1 overflow-auto">
			<!-- Typing area -->
            <div class="input-group">
                <input type="text" placeholder="Escribe un mensaje" class="form-control rounded-0 py-4 bg-light notes__input">
                <div class="input-group-append">
                    <button class="btn btn-link grey200_bg border notes__btn"> <i class="mdi mdi-send"></i></button>
                </div>
            </div>
			<div class="notes__box" data-d="<?=encode($data)?>">
                <?php
                
                //$aux = $_ITEC_temp -> select($data['table'], '*')[0];
                $msgs = $this -> _ITEC -> select('system__notes', '*', ['linked_table' => $data['table'], 'linked_id' => $data['id'], 'linked_dsn' => $data['dsn'], 'ORDER' => ['system__notes_id' => 'DESC']]);

                if($msgs){ 
                    foreach( $msgs as $msg ){
                        if( $msg['users_id'] === $_SESSION['uid'] ) { ?>
                            <!-- Mensaje propio -->
                            <div class="media w-75 ml-auto mb-3">
                                <div class="media-body text-right">
                                    <div class="bg-primary rounded py-2 px-3 mb-2">
                                        <p class="text-small mb-0 white"><?=$msg['message']?></p>
                                    </div>
                                    <p class="small text-muted"><?=$this -> _ITE -> funcs -> date_format( $msg['date'], 6)?> | <?=$this -> _ITE -> funcs -> date_format( $msg['date'], 2, ' de ')?></p>
                                </div>
                            </div>
                        <?php } else { 
                            $user = $this -> _ITEC -> get( 'users', 'user', ['users_id' => $msg['users_id']] ); 
                            ?>
                            <!-- Mensaje ajeno -->
                            <div class="media w-75 mb-3"><img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="50" class="rounded-circle" title="<?=$user?>">
                                <div class="media-body ml-3">
                                    <div class="bg-light rounded py-2 px-3 mb-2">
                                        <p class="text-small mb-0 text-muted"><?=$msg['message']?></p>
                                    </div>
                                    <p class="small text-muted"><?=$this -> _ITE -> funcs -> date_format( $msg['date'], 6)?> | <?=$this -> _ITE -> funcs -> date_format( $msg['date'], 2)?></p>
                                </div>
                            </div>
                        <?php } 
                    }
                } else {

                }
                ?>
            </div>
		</div>
		<?php
        $html = ob_get_contents();
        ob_end_clean();

		return $html;
	}

    public function gen_content( ) : string {       
        return $this -> make_notes();
    }
}