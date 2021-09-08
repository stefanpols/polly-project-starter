<div class="position-fixed text-start top-0 center end-0 p-3" style="z-index: 11">
    <?php use Polly\Core\Message;

    foreach(get_messages() as $message):?>
        <div class="toast align-items-center text-white bg-<?=$message['type']?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="icon">
                    <?php if($message['type'] == Message::DANGER): ?>
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    <?php elseif($message['type'] == Message::SUCCESS): ?>
                        <i class="bi bi-check-lg"></i>
                    <?php elseif($message['type'] == Message::INFO): ?>
                        <i class="bi bi-question"></i>
                    <?php else: ?>
                        <i class="bi bi-bell"></i>
                    <?php endif; ?>

                </div>
                <div class="toast-body">
                    <span class="title"><?=$message['title']?></span>
                    <?=$message['description']?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

