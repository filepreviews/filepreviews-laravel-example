<?php

namespace App\Listeners;

use Event;

use App\Document;
use App\Events\FilePreviewsGenerated;

class FilePreviewsSuccess
{
    /**
     * Handle the event.
     *
     * @param  array  $results
     * @return void
     */
    public function handle($results)
    {
        $document_id = $results['user_data']['document_id'];
        $document = Document::find($document_id);
        $document->preview_url = $results['preview']['url'];
        $document->preview = json_encode($results);
        $document->save();

        Event::fire(new FilePreviewsGenerated($document));
    }
}
