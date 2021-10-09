<div style="width: 340px; flex-shrink: 0; margin-right: 15px;">
    <div class="card text-center border-0">
        <div class="card-header fw-bold">
            READY
        </div>
        <div class="card-body" style="overflow-y: auto;height: 55vh;">
            <?php $classnyak->get_production_ready_schedule()?>
        </div>
    </div>
</div>
<div style="width: 340px; flex-shrink: 0; margin-right: 15px;">
    <div class="card text-center border-0">
        <div class="card-header fw-bold">
            ON GOING
        </div>
        <div class="card-body" style="overflow-y: auto;height: 55vh;">
            <?php $classnyak->get_production_ongoing_schedule()?>
        </div>
    </div>
</div>

<div style="width: 340px; flex-shrink: 0; margin-right: 15px;">
    <div class="card text-center border-0">
        <div class="card-header fw-bold">
            DONE (Hari ini)
        </div>
        <div class="card-body" style="overflow-y: auto;height: 55vh;">
            <?php $classnyak->get_production_done_schedule()?>
        </div>
    </div>
</div>