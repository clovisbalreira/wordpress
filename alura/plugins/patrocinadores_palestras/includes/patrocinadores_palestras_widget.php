<?php
add_action('widgets_init', 'patrocinadores_palestras_register_widget');

function patrocinadores_palestras_register_widget() {
    register_widget('Patrocinadores');
}

class Patrocinadores extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'patrocinadores_palestras_widget',     
            'Patrocinadores Palestras',
            array('description' => 'Selecione os patrocinadores da palestra')
        );
    }

    public function form($instance) {
        ?>
        <p> 
            <input type="checkbox" id="<?php echo $this->get_field_id('caelum'); ?>" name="<?php echo $this->get_field_name('caelum'); ?>" value="1" <?php checked('1', $instance['caelum']) ?>> 
            <label for="<?php echo $this->get_field_id('caelum'); ?>">Caelum</label> 
        </p> 
        <p> 
            <input type="checkbox" id="<?php echo $this->get_field_id('casa_do_codigo'); ?>" name="<?php echo $this->get_field_name('casa_do_codigo'); ?>" value="1" <?php checked('1', $instance['casa_do_codigo']) ?>> 
            <label for="<?php echo $this->get_field_id('casa_do_codigo'); ?>">Casa do Código</label> 
        </p> 
        <p> 
            <input type="checkbox" id="<?php echo $this->get_field_id('hipsters'); ?>" name="<?php echo $this->get_field_name('hipsters'); ?>" value="1" <?php checked('1', $instance['hipsters']) ?>> 
            <label for="<?php echo $this->get_field_id('hipsters'); ?>">Hipesters</label> 
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['caelum'] = (!empty($new_instance['caelum'])) ? strip_tags($new_instance['caelum']) : '';
        $instance['casa_do_codigo'] = (!empty($new_instance['casa_do_codigo'])) ? strip_tags($new_instance['casa_do_codigo']) : '';
        $instance['hipsters'] = (!empty($new_instance['hipsters'])) ? strip_tags($new_instance['hipsters']) : '';

        return $instance;
    }

    public function widget($args, $instance) {
        ?>
        <section class="patrocinadores-principais">
            <h3 class="titulo-patrocinadores">Patrocinadores</h3>
            <ul class="lista-patrocinadores">
                <?php if (!empty($instance['caelum'])) : ?>
                    <li>
                        <img src="<?php echo plugin_dir_url(__FILE__). '../imagens/caelum.svg'?>"></img>
                    </li>
                <?php endif; ?>
                <?php if (!empty($instance['casa_do_codigo'])) : ?>
                    <li>
                        <img src="<?php echo plugin_dir_url(__FILE__). '../imagens/cdc.svg'?>"></img>
                    </li>
                <?php endif; ?>
                <?php if (!empty($instance['hipsters'])) : ?>
                    <li>
                        <img src="<?php echo plugin_dir_url(__FILE__). '../imagens/hipsters.svg'?>"></img>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
        <?php
    }
}
