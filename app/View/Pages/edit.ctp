<div class="row">
    <div class="col-md-2">
        <button type="button" class="btn btn-danger">Logout</button>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-9">
        <?php
            echo $this->Form->create(null);
            echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Title', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'Description', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('content', array('class' => 'form-control', 'placeholder' => 'Content', 'type' => 'textarea','div' => array('class' => 'form-group')));
            echo $this->Form->submit('Update', array('class' => 'btn btn-default'));
            echo $this->Form->end();
        ?>
    </div>
</div>
