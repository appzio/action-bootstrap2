## Appzio components

Appzio components is a powerful way to organize your view code. If any of your view code will be or might be re-usable, it is adviced to include them as components. This will help you keep your view code more readable. Components have access to all components that view's have, so you can call components also within components.

### Model access

It is possible to access model from within components, but please note that components that access model, will NOT be compatible with NodeJS library.

### IMPORTANT: Make sure your components return objects

As your components will become part of the view code, its very important that they always return an object. If your component returns NULL for example, it will cause problems with the client.

### Working with DIVS

You can include divs directly from the components. They are appended to your normal view divs. You can include them in the following way (included in the beginning of the function).

        $this->addDivs(array(
            'uikit-report-item' => 'uiKitReportItemDiv',
            'uikit-remove-item' => 'uiKitRemoveItemDiv'
        ));
