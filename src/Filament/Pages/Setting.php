<?php

namespace Tenchology\Setting\Filament\Pages;

use Tenchology\Setting\Setting as SettingModel;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\LocaleSwitcher;
use Filament\Forms\Components;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Filament\Resources\Concerns\Translatable;

class Setting extends Page
{
    use interactsWithForms, Translatable;

    public ?string $activeLocale = null;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'settings::filament.pages.settings';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }
    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }

    public function getHeading(): string|Htmlable
    {
        return __("Settings");
    }

    public function getFilamentTranslatableContentDriver(): ?string
    {
        return $this->getJsonFile(base_path('settings.json'));
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make()->placeholder('Language'),
            Action::make('submit')->label(__('Save'))->color('success')->icon('heroicon-o-check')->action('submit'),
        ];
    }

    public ?array $data = [];

    public function mount(SettingModel $setting): void
    {
        $this->form->fill($setting->pluck('value', 'key')->toArray());
    }

    public function updatedInteractsWithForms(string $statePath): void
    {
        $results = SettingModel::all(); // Replace YourModel with your actual model class

        $keyValuePairs = $results->mapWithKeys(function ($item) {
            $item->setLocale($this->activeLocale ?? app()->getLocale());
            return [$item->key => $item->value ];
        });

        if($statePath == 'activeLocale') {
            $this->form->fill($keyValuePairs->toArray());
        }
    }

    public function form(Form $form): Form
    {
        $settings_fields = config()->get('settings_fields');



        $theme_options = $this->getJsonFile(base_path('themes/'.setting('app_theme', 'default').'/theme_settings.json'));
        $settings_fields['theme']['elements'] = array_merge($settings_fields['theme']['elements'] ?? [], $theme_options['elements'] ?? []);

        // loop through every themeName folders in themes and get the name of each theme from it's setting.json file and add it to the theme select dropdown
        $theme_names = Arr::mapWithKeys(File::directories(base_path('themes')), function ($value, $key) {
            if (File::exists($value. '/theme_settings.json')) {
                $themeSetting = json_decode(File::get($value. '/theme_settings.json'), true);
                return [ basename($value) => $themeSetting['name']];
            }
            return null;
        });

        $settings_fields['theme']['elements'][0]['options'] = $theme_names;

        $mapped = Arr::mapWithKeys($settings_fields ?? [], function (array $value, string $key) {
            $types = Arr::map($value['elements'], function (array $element) {
                return $this->types_match($element);
            });
            return [
                $key => Tabs\Tab::make(__(Str::title($key)))->schema($types)->icon($value['icon'] ?? 'heroicon-o-cog-6-tooth'),
            ];
        });

        return $form
            ->schema([
                Tabs::make('Tabs')->tabs($mapped ?? []),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        try {
            foreach ($this->form->getState() as $key => $value) {
                SettingModel::set($key, $value, $this->activeLocale);
            }
        }catch (Exception $exception) {
            Notification::make()->title($exception->getMessage())->danger()->send();
        }

        Notification::make()->title(__('Settings Updated'))->success()->send();

    }


    private function types_match($element)
    {
        if ($element['type'] === 'select')
        {
            $options = array_key_exists('class', $element) ? ((new $element['class'])->pluck($element['valueCol'], $element['keyCol'])->toArray()) : $element['options'];
        }
        return match ($element['type']) {
            'select' => Components\Select::make($element['key'])->label(__($element['title']))->options($options)->helperText(new HtmlString(__($element['help']  ?? '')))->multiple($element['multiple'] ?? false)->searchable()->inlineLabel(),
            'toggleButtons' => Components\ToggleButtons::make($element['key'])->label(__($element['title']))->options($element['options'])->inline()->inlineLabel(),
            'textarea' => Components\TextArea::make($element['key'])->label(__($element['title']))->helperText(new HtmlString(__($element['help']  ?? '')))->inlineLabel(),
            'checkbox' => Components\Toggle::make($element['key'])->label(__($element['title']))->helperText(new HtmlString(__($element['help']  ?? '')))->inlineLabel(),
            'upload' => Components\FileUpload::make($element['key'])->label(__($element['title']))->image()->imageEditor()->helperText(new HtmlString(__($element['help']  ?? '')))->inlineLabel(),
            'mdeditor' => Components\MarkdownEditor::make($element['key'])->label(__($element['title']))->helperText(new HtmlString(__($element['help']  ?? '')))->inlineLabel(),
            'color' => Components\ColorPicker::make($element['key'])->label(__($element['title']))->helperText(new HtmlString(__($element['help']  ?? '')))->inlineLabel(),
            'editor' => Components\RichEditor::make($element['key'])->label(__($element['title']))->helperText(new HtmlString(__($element['help']  ?? '')))->disableToolbarButtons(['codeBlock', 'undo', 'redo'])->inlineLabel(),
            'tagsInput' => Components\TagsInput::make($element['key'])->label(__($element['title']))->helperText(new HtmlString(__($element['help']  ?? '')))->inlineLabel(),
            default => Components\TextInput::make($element['key'])->label(__($element['title']))->helperText(new HtmlString(__($element['help']  ?? '')))->placeholder(__($element['placeholder']  ?? ''))->inlineLabel(),
        };
    }

    private function getJsonFile($file_path)
    {
        if (app('files')->exists($file_path)) {
            return app('files')->json($file_path);
        }else{
            return [];
        }
    }

}
