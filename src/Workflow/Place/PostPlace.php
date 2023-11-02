<?php

namespace App\Workflow\Place;

enum PostPlace: string
{
    case INITIALISATION = 'Initialisation';

    case IN_DRAFT = 'In draft';

    case WROTE = 'Wrote';

    case REVIEWED = 'Reviewed';

    case DECORATED = 'Decorated';

    case UNPUBLISHED = 'UnPublished';

    case PUBLISHED = 'Published';

}
