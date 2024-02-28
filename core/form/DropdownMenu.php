<?php
namespace app\core\form;

use app\core\Model;

class DropdownMenu
{
    public Model $model;
    public string $attribute;
    public array $options;

    public function __construct(Model $model, string $attribute, array $options)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->options = $options;
    }

    public function render(): string
    {
        $optionsHtml = $this->renderOptions();
        
        return sprintf(
            '<div class="mb-3">
                <label>%s</label>
                <select name="%s" class="form-select">
                    %s
                </select>
                <div class="invalid-feedback">%s</div>
            </div>',
            $this->attribute,
            $this->attribute,
            $optionsHtml,
            $this->model->getFirstError($this->attribute)
        );
    }

    protected function renderOptions(): string
    {
        $optionsHtml = '';
        
        foreach ($this->options as $key => $value) {
            $selected = $key == $this->model->{$this->attribute} ? 'selected' : '';
            $optionsHtml .= sprintf('<option value="%s" %s>%s</option>', htmlspecialchars($value), $selected, htmlspecialchars($key));
        }
        
        return $optionsHtml;
    }
}
?>
