<?php


namespace App\Filament\Customer\Resources\MyGalleryResource\Pages;


use App\Models\Gallery;
use Filament\Forms\Form;
use Livewire\Attributes\Locked;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Concerns\InteractsWithFormActions;
use App\Filament\Customer\Resources\MyGalleryResource;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GaleriSaya extends Page
{
    use InteractsWithFormActions;

    protected static string $resource = MyGalleryResource::class;

    protected static string $view = 'filament.customer.resources.my-gallery-resource.pages.galeri-saya';


    protected static ?string $title = 'Galeri Saya';

    public array $data = [];

    #[Locked]
    public ?Gallery $record = null;

    public function getTitle(): string | Htmlable
    {
        return "Gallery";
    }

    // Mount method to initialize values before form is rendered
    public function mount(): void
    {

        // $this->record = Gallery::firstOrNew([
            // 'user_id' => auth()->user()->id,
        // ]);

        $this->record = new Gallery();

        // abort_unless(static::canView($this->record), 404);

        $this->fillForm();
    }

    public function fillForm(): void
    {
        $data = $this->record->attributesToArray();

        $this->form->fill($data);
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'));
    }

    // public function save(): void
    // {
    //     try {
    //         $data = $this->form->getState();

    //         $this->handleRecordUpdate($this->record, $data);

    //     } catch (Halt $exception) {
    //         return;
    //     }

    //     $this->getSavedNotification()->send();
    // }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            Gallery::create([
                'customer_id' => auth()->user()->customer->id,
                'link_gambar' => $data['link_gambar'],
                'deskripsi'   => $data['deskripsi'] ?? null,
                'upload_by'   => auth()->user()->name,
                // 'created_by'  => auth()->id(),
            ]);

            $this->dispatch('galleryUpdated');

            $this->form->fill();

        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title('Gallery berhasil disimpan')
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getFormInputImageSection(),
                $this->getGridImageSection(),
            ])
            ->model($this->record)
            ->statePath('data')
            ->operation('edit');
    }

    protected function getFormInputImageSection(): Component
    {
        return Section::make('Profile')
            ->schema([
                    FileUpload::make('link_gambar')
                        ->openable()
                        ->maxSize(1024)
                        ->visibility('public')
                        ->disk('public')
                        ->directory('logos/company')
                        ->imageResizeMode('contain')
                        ->imageCropAspectRatio('1:1')
                        ->panelAspectRatio('1:1')
                        ->panelLayout('integrated')
                        ->removeUploadedFileButtonPosition('center bottom')
                        ->uploadButtonPosition('center bottom')
                        ->uploadProgressIndicatorPosition('center bottom')
                        ->getUploadedFileNameForStorageUsing(
                            static fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                ->prepend(Auth::user()->id . '_'),
                        )
                        ->extraAttributes(['class' => 'w-32 h-32'])
                        ->acceptedFileTypes(['image/png', 'image/jpeg']),

                    Textarea::make('deskripsi'),

            ])->columns(2);
    }

    protected function getGridImageSection(): Component
    {
        return Section::make('Gallery Saya')
            ->schema([
                ViewField::make('gallery_grid')
                    ->view('filament.customer.components.gallery-grid')
                    ->columnSpanFull(),
            ]);
    }

}
