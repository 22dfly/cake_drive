<div class="row">
    <div class="col-md-2">
        <button type="button" class="btn btn-danger">Logout</button>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-9">
        <table class="table" style="margin-bottom: 100px;">
            <tr>
                <th width="25%">#</th>
                <th>Title</th>
            </tr>
            <?php foreach ($files as $index => $file) : ?>
            <tr>
                <td><?php echo ($index + 1) ?></td>
                <td><?php echo $this->Html->link($file['title'], array('action' => 'edit', $file['id'])) ?></td>
            </tr>
            <?php endforeach ?>
        </table>
        <?php echo $this->Html->link('Create', array('action' => 'create'), array('class' => 'btn btn-success')); ?>
    </div>
</div>
