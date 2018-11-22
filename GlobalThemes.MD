### About global themes

Themes are a new way to arrange code inside Appzio. When your application relies on multiple actions / action themes that share same components, styles and images, you can use the theme instead or organizing the code inside actions or their themes.

### Order of style inclusion

Theme styles are applied before any action's styles, so they can be overriden in the action's theme. However, if you use theme for your action, its recommended not to put any styles in the actions themeselves for better organization.

### GIT modules

Theme should be included into the project as a GIT submodule.

### About namings

Its recommended to use general namings for your components, so that in case the theme needs to be duplicated, you don't need to replace code inside actions. Components should always start with word theme. So for example Button component becomes themeButton.

### How to include theme

Simply have your Components.php inside the action or action's theme extend the baseclass. So for example, a theme called uikit2 would be like this:

~~~~
namespace packages\actionMlogin\themes\uikit2\Components;

use BootstrapThemes\Uikit2\Components\UikitComponents;

class Components extends UikitComponents {

}
~~~~

### Main theme file

Main theme file needs to have these elements defined:

~~~~

namespace BootstrapThemes\Uikit2\Components;

use Bootstrap\Components\BootstrapComponent;

class Uikit2Components extends BootstrapComponent {

    use themeButton;

    /* you need to have this constructor so that styles & images get loaded properly */
    public function __construct($obj)
    {
        parent::__construct($obj);
        $searchpath = \Yii::getPathOfAlias('application.modules.aelogic.BootstrapThemes.Uikit2.Images');
        $this->imagesobj->imagesearchpath[] = $searchpath .'/';
        $this->registerTheme('Uikit2');
    }


}
~~~~
