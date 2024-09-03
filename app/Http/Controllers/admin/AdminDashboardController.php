<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'Pname' => 'required|string|max:255',
            'Pdesc' => 'required|string|max:500',
            'Pprice' => 'required|numeric|min:0',
            'Pqty' => 'required|integer|min:1',
            'Pweight' => 'required|numeric|min:0',
            'Pdimen' => 'required|string|max:255',
            'Pimg' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')->withInput()->withErrors($validator);
        }

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('Pimg')) {
            $image = $request->file('Pimg');
            $imagePath = $image->store('public/images'); 
        }
        // Insert new product into the database
        DB::table('tb_products')->insert([
            'Product_name' => $request->Pname,
            'Description' => $request->Pdesc,
            'price' => $request->Pprice,
            'quantity' => $request->Pqty,
            'weight' => $request->Pweight,
            'dimensions' => $request->Pdimen,
            'image_url' => basename($imagePath), // Save the path to the image
            'status' => $request->status ?? 'active', // Use a default value if status is not provided
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }
    public function edit(Request $request) {
		$id = $request->id;
		$pro = Product::find($id);
		return response()->json($pro);
	}
    // handle update an employee ajax request
	public function update(Request $request) {
		$fileName = '';
		$pro = Product::find($request->edit_pro_id);
		if ($request->hasFile('edit_Pimg')) {
			$file = $request->file('edit_Pimg');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('/public/images', $fileName);
			if ($pro->image_url) {
				Storage::delete('/public/images/' . $pro->image_url);
			}
		} else {
			$fileName = $request->edit_pro_img;
		}

		$proData = ['Product_name' => $request->edit_Pname, 'Description' => $request->edit_Pdesc, 'price' => $request->edit_Pprice, 'quantity' => $request->edit_Pqty, 'weight' => $request->edit_Pweight, 'dimensions' => $request->edit_Pdimen,'image_url'=>$fileName,'status' => $request->edit_status??$pro->status];

		$pro->update($proData);
		return response()->json([
			'status' => 200,
		]);
	}
    public function delete(Request $request) {
		$id = $request->id;
		$pro = Product::find($id);
		if (Storage::delete('public/images/' . $pro->image_url)) {
			Product::destroy($id);
		}
	}
    public function fetchAll()
    {
        $prod = Product::all();
        $output = '';
        if ($prod->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Weight</th>
                <th>Dimensions</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($prod as $p) {
                $output .= '<tr>
                <td>' . $p->id . '</td>
                <td>' . $p->Product_name . '</td>
                <td>' . $p->Description . '</td>
                <td>' . $p->price . '</td>
                <td>' . $p->quantity . '</td>
                <td>' . $p->weight . '</td>
                <td>' . $p->dimensions . '</td>
                <td><img type="image" src="' . asset('storage/images/' . $p->image_url) . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>'. $p->status . '</td>
                <td>
                  <a href="#" id="' . $p->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editProductModal"><i class="bi-pencil-square h4"></i></a>
                  <a href="#" id="' . $p->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }
}
