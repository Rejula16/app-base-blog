<?php
namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\HashTag;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Ynotz\EasyAdmin\Services\FormHelper;
use Modules\Ynotz\EasyAdmin\Services\IndexTable;
use Modules\Ynotz\EasyAdmin\Traits\IsModelViewConnector;
use Modules\Ynotz\EasyAdmin\Contracts\ModelViewConnector;
use Modules\Ynotz\EasyAdmin\RenderDataFormats\CreatePageData;
use Modules\Ynotz\EasyAdmin\RenderDataFormats\EditPageData;
use Modules\Ynotz\EasyAdmin\Services\ColumnLayout;
use Modules\Ynotz\EasyAdmin\Services\RowLayout;

class ArticleService implements ModelViewConnector {
    use IsModelViewConnector;
    private $indexTable;

    public function __construct()
    { 
        $this->modelClass = Article::class;
        $this->indexTable = new IndexTable();
        $this->selectionEnabled = true;

        // $this->idKey = 'id';
        // $this->selects = '*';
        // $this->selIdsKey = 'id';
        // $this->searchesMap = [];
        // $this->sortsMap = [];
        // $this->filtersMap = [
        //     'author' => 'user_id' // Example
        // ];
        // $this->orderBy = ['created_at', 'desc'];
        // $this->sqlOnlyFullGroupBy = true;
        // $this->defaultSearchColumn = 'name';
        // $this->defaultSearchMode = 'startswith';
        // $this->relations = [];
        // $this->selectionEnabled = false;
        // $this->downloadFileName = 'results';
    }

    protected function relations()
    {
        // return [];
        // // Example:
        return [
            'author' => [
                'search_column' => 'id',
                'filter_column' => 'id',
                'sort_column' => 'id',
            ],
            'category' => [
                'search_column' => 'id',
                'filter_column' => 'id',
                'sort_column' => 'id',
            ],
            'hashTags' => [
                'search_column' => 'id',
                'filter_column' => 'id',
                'sort_column' => 'id',
            ],
            // 'reviewScore' => [
            //     'search_column' => 'score',
            //     'filter_column' => 'id',
            //     'sort_column' => 'id',
            // ],
        ];
    }
    protected function getPageTitle(): string
    {
        return "Articles";
    }

    protected function getIndexHeaders(): array
    {
        // return [];
        // // Example:
        return $this->indexTable->addHeaderColumn(
            title: 'Title',
            sort: ['key' => 'title'],
        )->addHeaderColumn(
            title: 'Author',
            filter: ['key' => 'id', 'options' => User::all()->pluck('name', 'id')]
        // )->addHeaderColumn(
        //     title: 'Review Score',
        )->addHeaderColumn(
            title: 'Actions'
        )->getHeaderRow();
    }

    protected function getIndexColumns(): array
    {
        // return [];
        // // Example:
        return $this->indexTable->addColumn(
            fields: ['title'],
        )->addColumn(
            fields: ['name'],
            relation: 'author',
        // )->addColumn(
        //     fields: ['score'],
        //     relation: 'reviewScore',
        )
        ->addActionColumn(
            editRoute: $this->getEditRoute(),
            deleteRoute: $this->getDestroyRoute(),
        )->getRow();
    }

    public function getAdvanceSearchFields(): array
    {
        return [];
        // // Example:
        // return $this->indexTable->addSearchField(
        //     key: 'title',
        //     displayText: 'Title',
        //     valueType: 'string',
        // )
        // ->addSearchField(
        //     key: 'author',
        //     displayText: 'Author',
        //     valueType: 'list_string',
        //     options: User::all()->pluck('name', 'id')->toArray(),
        //     optionsType: 'key_value'
        // )
        // ->addSearchField(
        //     key: 'reviewScore',
        //     displayText: 'Review Score',
        //     valueType: 'numeric',
        // )
        // ->getAdvSearchFields();
    }

    public function getDownloadCols(): array
    {
        return [];
        // // Example
        // return [
        //     'title',
        //     'author.name'
        // ];
    }

    public function getDownloadColTitles(): array
    {
        return [
            'title' => 'Title',
            'author.name' => 'Author'
        ];
    }

    public function getCreatePageData(): CreatePageData
    {
        return new CreatePageData(
            title: 'Create Article',
            form: FormHelper::makeForm(
                title: 'Create Article',
                id: 'form_articles_create',
                action_route: 'articles.store',
                success_redirect_route: 'articles.index',
                items: $this->getCreateFormElements(),
                layout: $this->buildCreateFormLayout(),
                label_position: 'top'
            )
        );
    }

    public function getEditPageData($id): EditPageData
    {
        return new EditPageData(
            title: 'Edit Article',
            form: FormHelper::makeEditForm(
                title: 'Edit Article',
                id: 'form_articles_create',
                action_route: 'articles.update',
                action_route_params: ['id' => $id],
                success_redirect_route: 'articles.index',
                items: $this->getEditFormElements(),
                label_position: 'top'
            ),
            instance: $this->getQuery()->where('id', $id)->get()->first()
        );
    }

    /*
    public function getShowPageData($id): ShowPageData
    {
        return new ShowPageData(
            Str::ucfirst($this->getModelShortName()),
            $this->getQuery()->where($this->key, $id)->get()->first()
        );
    }
    */

    private function formElements(): array
    {
        // return [];
         return [
            'title' => FormHelper::makeInput(
                inputType: 'text',
                key: 'title',
                label: 'Title',
                properties: ['required' => true],
            ),
            'body' => FormHelper::makeTextarea(
                key: 'body',
                label: 'Description'
            ),
            'category'=>FormHelper::makeSelect(
                key: 'category',
                label: 'Category',
                options: Category::all(),
                options_type: 'collection',
                options_id_key: 'id',
                options_text_key: 'name',
                options_src: [CategoryService::class, 'suggestList'],
                properties: [
                    // 'required' => true,
                    // 'multiple' => true
                ],
               
            ), 'hashtags'=>FormHelper::makeSelect(
                key: 'hashtags',
                label: 'HashTag',
                options: HashTag::all(),
                options_type: 'collection',
                options_id_key: 'id',
                options_text_key: 'name',
                options_src: [HashTagService::class, 'suggestList'],
                properties: [
                    // 'required' => true,
                    'multiple' => true
                ],
            ),
            
        ];
        // // Example:
        // return [
        //     'title' => FormHelper::makeInput(
        //         inputType: 'text',
        //         key: 'title',
        //         label: 'Title',
        //         properties: ['required' => true],
        //     ),
        //     'description' => FormHelper::makeTextarea(
        //         key: 'description',
        //         label: 'Description'
        //     ),
        // ];
    }

    private function getQuery()
    {
      
        return $this->modelClass::query();
   
        // // Example:
        // return $this->modelClass::query()->with([
        //     'author' => function ($query) {
        //         $query->select('id', 'name');
        //     }
        // ]);
    }

    public function getStoreValidationRules(): array
    {
        // return [];

        // // Example:
        return [
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
            'category'=>['required'],
            'hashtags'=>['required']
        ];
    }

    public function getUpdateValidationRules($id): array
    {
        // return [];
        // // Example:

         $arr = $this->getStoreValidationRules();
        return $arr;
        // $arr = $this->getStoreValidationRules();
        // return $arr;
    }
    private function syncHashtagsWithArticle(Article $article, array $hashtagIds): void
{
    $article->hashtags()->sync($hashtagIds);
}

    public function processBeforeStore(array $data): array
    {
        // // Example:
        // foreach($data as $d){echo($d);echo("            ");}
        // echo($d);
        // $data['user_id'] = auth()->user()->id;
        $data['user_id'] = auth()->user()->id;
        $data['category_id']=$data['category'];
        unset($data['category']);

        // dd($data); 
        
        return $data;
    }

    public function processBeforeUpdate(array $data): array
    {
        // // Example:
        // $data['user_id'] = auth()->user()->id;
        $data['user_id'] = auth()->user()->id;
        $data['category_id']=$data['category'];
        unset($data['category']);

        return $data;
    }

    public function processAfterStore($instance): void
    {
        // Extract hashtag IDs from the request data
    $hashtagIds = request()->input('hashtags');

    // Get the newly created article instance
    $article = $instance;

    // Sync hashtags with the article
    $this->syncHashtagsWithArticle($article, $hashtagIds);
        //Do something with the created $instance
    }

    public function processAfterUpdate($oldInstance, $instance): void
    {

         // Extract hashtag IDs from the request data
    $hashtagIds = request()->input('hashtags');

    // Get the updated article instance
    $article = $instance;

    // Sync hashtags with the article
    $this->syncHashtagsWithArticle($article, $hashtagIds);
        //Do something with the updated $instance
    }

    public function buildCreateFormLayout(): array
    {
        // return (new ColumnLayout())->getLayout();
         $layout = (new ColumnLayout())
            ->addElements([
                    (new RowLayout())
                        ->addElements([
                            (new ColumnLayout(width: '1'))->addInputSlot('title'),
                        ])
                ])
                ->addElements([
                (new RowLayout())
                    ->addElements([
                        (new ColumnLayout(width: '1'))->addInputSlot('body'),
                    ])
            ])
            ->addElements([
                (new RowLayout())
                    ->addElements([
                        (new ColumnLayout(width: '1'))->addInputSlot('category'),
                    ])
            ])
            ->addElements([
                (new RowLayout())
                    ->addElements([
                        (new ColumnLayout(width: '1'))->addInputSlot('hashtags'),
                    ])
            ]);
        return $layout->getLayout();
        // // Example
        //  $layout = (new ColumnLayout())
        //     ->addElements([
        //             (new RowLayout())
        //                 ->addElements([
        //                     (new ColumnLayout(width: '1/2'))->addInputSlot('title'),
        //                     (new ColumnLayout(width: '1/2'))->addInputSlot('description'),
        //                 ])
        //         ]
        //     );
        // return $layout->getLayout();
    }
}

?>
