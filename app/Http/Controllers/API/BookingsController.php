<?php

namespace App\Http\Controllers\API;

use App\Events\NotificationEvent;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingStore;
use App\Models\Booking;
use App\Models\Notification;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/bookings",
     *     tags={"Booking"},
     *     summary="List of all Bookings",
     *     security={{"bearer_token": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of bookings"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Un-Athenticated"
     *     ),
     * )
     */

    public function index()
    {
        try {
            // Fetch data with relationships
            $query = Booking::with('userDetail', 'serviceDetail');

            if (Auth::user()->hasRole('Client')) {

                $query->where('users_id', Auth::id());
            }
            $data = $query->get();
            // Prepare response data
            $responseCode = Response::HTTP_OK;
            $responseMessage = 'Success';
            $responseData = $data;
            $sqlState = 00000;

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle query exception
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseMessage = 'Database query error';
            $responseData = $e->getMessage();
            $sqlState = $e->getCode();
            \Log::error('QueryException: ' . $e->getMessage());

        }

        // Return standardized JSON response
        return ResponseHelper::returnReponse($responseCode, $responseMessage, $responseData, $sqlState);
    }

    /**
     * @OA\Post(
     *     path="/bookings",
     *     tags={"Booking"},
     *     summary="Create new booking",
     *     security={{"bearer_token": {}}},
     *     operationId="Booking Store",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="users_id", type="integer"),
     *             @OA\Property(property="services_id", type="integer"),
     *             @OA\Property(property="created_by", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */

    public function store(BookingStore $request)
    {

        try {
            $booking = new Booking();
            $booking->users_id = $request->users_id;
            $booking->services_id = $request->services_id;
            $booking->created_by = Auth::id();

            $booking->save();

            $notification = Notification::create([
                'users_id' => 1,
                'type' => 'Booking Created',
                'data' => 'New Booking has been added.',
                'read' => 0,
            ]);
            broadcast(new NotificationEvent($notification))->toOthers();

            $responseCode = Response::HTTP_OK;
            $responseData = $booking;
            $responseMessage = 'Success';
            $sqlState = 00000;

        } catch (\Exception $e) {
            $errorMessage = "Exception Error";
            $responseCode = Response::HTTP_EXPECTATION_FAILED;
            $responseData = $e->getMessage();
            $responseMessage = "Exception";
            $sqlState = $e->getCode();
        }
        return ResponseHelper::returnReponse($responseCode, $responseMessage, $responseData, $sqlState);
    }

    /**
     * @OA\Put(
     *     path="/bookings/{id}",
     *     tags={"Booking"},
     *     summary="Update booking",
     *     security={{"bearer_token": {}}},
     *     operationId="Booking update",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="users_id", type="integer"),
     *             @OA\Property(property="services_id", type="integer"),
     *             @OA\Property(property="created_by", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */

    public function update(BookingStore $request, $id)
    {

        try {
            $booking = Booking::where('id', $id)->first();
            $booking->users_id = $request->users_id;
            $booking->services_id = $request->services_id;
            $booking->created_by = Auth::id();

            $booking->save();

            $notification = Notification::create([
                'users_id' => 1,
                'type' => 'Booking Created',
                'data' => 'New Booking has been added.',
                'read' => 0,
            ]);
            broadcast(new NotificationEvent($notification))->toOthers();

            $responseCode = Response::HTTP_OK;
            $responseData = $booking;
            $responseMessage = 'Success';
            $sqlState = 00000;

        } catch (\Exception $e) {
            $errorMessage = "Exception Error";
            $responseCode = Response::HTTP_EXPECTATION_FAILED;
            $responseData = $e->getMessage();
            $responseMessage = "Exception";
            $sqlState = $e->getCode();
        }
        return ResponseHelper::returnReponse($responseCode, $responseMessage, $responseData, $sqlState);
    }

    /**
     * @OA\Delete(
     *     path="/bookings/{id}",
     *     tags={"Booking"},
     *     summary="Delete booking",
     *     security={{"bearer_token": {}}},
     *     operationId="Booking Delete",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Record Not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();

            $responseCode = Response::HTTP_OK;
            $responseData = null;
            $responseMessage = 'Deleted';
            $sqlState = "00000";

        } catch (ModelNotFoundException $e) {
            $responseCode = Response::HTTP_NOT_FOUND;
            $responseData = null;
            $responseMessage = 'Booking not found';
            $sqlState = $e->getCode();

        } catch (\Exception $e) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseData = $e->getMessage();
            $responseMessage = 'An error occurred';
            $sqlState = $e->getCode();
        }

        return ResponseHelper::returnReponse($responseCode, $responseMessage, $responseData, $sqlState);
    }
}
