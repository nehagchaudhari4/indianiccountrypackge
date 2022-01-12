<?php

namespace Indianiic\Country\Controllers;

use App\Http\Controllers\Controller;
use Indianiic\Country\Requests\CountryRequest;
use Indianiic\Country\Models\Country;
use Indianiic\Country\DataGrids\CountryDataGrid;
use Indianiic\Country\Repositories\CountryRepository;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class CountryController extends Controller
{
    /**
     * @var Repository
     */
    protected $model;

    /**
     * CountryController constructor.
     * @param Country $model
     */
    public function __construct(Country $model)
    {
        $this->model = new CountryRepository($model);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dataGridHtml = CountryDataGrid::getHTML();
        return view('country::index', compact('dataGridHtml'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\Indianiic\Country\Forms\CountryForm::class, [
                    'method' => 'POST',
                    'class' => 'row',
                    'url' => route('admin.countries.store')
                ]);

        return view('country::create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Country  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        $data = $request->all();
        $data['flag']=$this->uploadFlagPicToS3($data);
        $country = $this->model->create($data);
        return redirect()->route('admin.countries.index')->with([
            'message' => __('Country Added Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decrypt($id);
        return view('country::show', ['model' => $this->model->show($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $id = decrypt($id);
        $model = $this->model->show($id);
        $src = \Storage::url($model->flag);
        $form = $formBuilder->create('Indianiic\Country\Forms\CountryForm', [
                    'model' => $model,
                    'class' => 'row',
                    'method' => 'PUT',
                    'url' => route('admin.countries.update', encrypt($id)),
                     'data' => ['flag' => $src]
                ]);
        return view('country::edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CountryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        $id = decrypt($id);
        $data = $request->all();
        
        // $country = $this->model->show($id);
        if (!empty($data['flag'])) {
            $data['flag']=$this->uploadFlagPicToS3($data);
             
        }
        $this->model->update($data, $id);
        return redirect()->route('admin.countries.index')->with([
            'message' => __('Country Updated Successfully.')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $this->model->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => __('Country deleted Successfully.')
        ]);
    }

    /**
     * Change the Status of the Country.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        try {
            if ($request->ajax()) {
                if ($request->input('id') > 0) {
                    $model = $this->model->show($request->input('id'));
                    if ($model['status'] === 'Inactive') { //make status Active
                        $data['status'] = 'Active';
                        $status = 'Activated';
                    } else { //make status Inactive
                        $data['status'] = 'Inactive';
                        $status = 'De-activated';
                    }
                    $this->model->update($data, $request->input('id'));
                    return response()->json(['status' => 'success', 'message' => __('Country has been ' . $status . ' successfully.'), 'alert-type' => 'success']);
                }
                return response()->json(['status' => 'error', 'message' => __('Something went wrong.'), 'alert-type' => 'error']);
            }
        } catch (\Exception  $e) {
            return response()->json(['message' => __($e->getMessage()), 'alert-type' => 'error']);
        }
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  Country  $request
     * @return \Illuminate\Http\Response
     */

    public function uploadFlagPicToS3($data){
        $extension = $data['flag']->getClientOriginalExtension();
        $fileName  = \Str::slug($data['flag'])."-".uniqid().'.'.$extension;
        if(env('FILESYSTEM_DRIVER')=='s3'){
            \Storage::disk('s3')->put('flags/'.$fileName, file_get_contents($data['flag']));
        }else{
            \Storage::disk('public')->put('flags/'.$fileName, file_get_contents($data['flag']));
        }
        return 'flags/'.$fileName;
    }

    
}
