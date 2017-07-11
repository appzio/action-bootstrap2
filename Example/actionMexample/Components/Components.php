<?php

namespace packages\actionMexample\Components;

use Bootstrap\Components\BootstrapComponent;

/* all components need to be define here. Idea is that the
components should be easily movable between the actions,
so they should be fairly self-contained */

class Components extends BootstrapComponent {

    use getPhotoField;
    use getShadowBox;
    use getIconField;
    use getPhoneNumberField;
    use getDivPhoneNumbers;

}