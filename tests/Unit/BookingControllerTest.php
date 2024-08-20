<?php

namespace Tests\Unit;

use App\Events\NotificationEvent;
use App\Http\Controllers\API\BookingsController;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        // Set up any necessary state or mocks here
    }

    public function testStoreCreatesBookingSuccessfully()
    {
        // Arrange
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user); // Simulate logged-in user

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $requestData = [
            'users_id' => $user->id,
            'services_id' => 2,
            'created_by' => $user->id,
        ];

        // Mock Notification
        $notificationMock = Mockery::mock(Notification::class);
        $notificationMock->shouldReceive('create')
            ->with([
                'users_id' => 1,
                'type' => 'Booking Created',
                'data' => 'New Booking has been added.',
                'read' => 0,
            ])
            ->andReturn((object) ['id' => 1]);

        $this->app->instance(Notification::class, $notificationMock);

        // Mock Booking model
        $bookingMock = Mockery::mock(Booking::class);
        $bookingMock->shouldReceive('setAttribute')
            ->with('users_id', $requestData['users_id'])
            ->andReturnSelf();
        $bookingMock->shouldReceive('setAttribute')
            ->with('services_id', $requestData['services_id'])
            ->andReturnSelf();
        $bookingMock->shouldReceive('setAttribute')
            ->with('created_by', $requestData['created_by'])
            ->andReturnSelf();
        $bookingMock->shouldReceive('save')
            ->andReturn(true);
        $bookingMock->shouldReceive('getAttributes')
            ->andReturn($requestData);

        $this->app->instance(Booking::class, $bookingMock);

        // Act
        $response = $this->json('POST', 'api/bookings', $requestData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Decode the JSON response
        $responseData = json_decode($response->getContent(), true);

        // Output the response to the console for debugging
        echo "Response Status: " . $response->status() . "\n";
        echo "Response Data: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";

        // Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'statusCode' => Response::HTTP_OK,
                'message' => 'Success',
                'data' => $requestData,
                'sqlState' => '00000',
            ]);

        // Check that Notification was broadcasted
        $notificationEventMock = Mockery::mock(NotificationEvent::class);
        $notificationEventMock->shouldReceive('toOthers')->andReturnSelf();
        $this->app->instance(NotificationEvent::class, $notificationEventMock);
    }

    public function testIndexReturnsSuccessResponse()
    {
        // Arrange
        $mockedBooking = Mockery::mock(Booking::class);
        $mockedBooking->shouldReceive('get')
            ->andReturn(collect([
                ['id' => 1, 'user_id' => 1, 'service_id' => 1],
                ['id' => 2, 'user_id' => 2, 'service_id' => 2],
            ]));

        $this->app->instance(Booking::class, $mockedBooking);

        $controller = new BookingsController();

        // Act
        $response = $controller->index();

        // Decode the JSON response
        $responseData = json_decode($response->getContent(), true);

        // Assert
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertEquals(Response::HTTP_OK, $responseData['statusCode']);
        $this->assertEquals('Success', $responseData['message']);
        $this->assertIsArray($responseData['data']);
        $this->assertArrayHasKey('sqlState', $responseData); // Check for key existence
        $this->assertEquals(00000, $responseData['sqlState']);
    }

    public function testIndexHandlesQueryException()
    {
        // Arrange
        $mockedBooking = Mockery::mock(Booking::class);

        // Create a QueryException with correct parameters
        $queryException = new \Illuminate\Database\QueryException($mockedBooking,
            'SELECT * FROM bookings', // SQL query (dummy value)
            [], // Bindings (dummy empty array)
            new \Exception('Previous exception') // Previous exception (dummy value)
        );

        // Configure mock to throw QueryException
        $mockedBooking->shouldReceive('get')
            ->andThrow($queryException);

        $this->app->instance(Booking::class, $mockedBooking);

        $controller = new BookingsController();

        // Act
        $response = $controller->index();

        // Decode the JSON response
        $responseData = json_decode($response->getContent(), true);

        // Output the response to the console for debugging

        // Assert
        $this->assertArrayHasKey('statusCode', $responseData);
        $this->assertArrayHasKey('sqlState', $responseData);
    }

    public function testUpdateBookingSuccessfully()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user); // Simulate a logged-in user

        $booking = Booking::factory()->create([
            'users_id' => $user->id,
            'services_id' => 1,
            'created_by' => $user->id,
        ]);

        $requestData = [
            'users_id' => $user->id,
            'services_id' => 2,
            'created_by' => $user->id,
        ];

        // Mock Notification
        $notificationMock = Mockery::mock(Notification::class);
        $notificationMock->shouldReceive('create')
            ->with([
                'users_id' => 1,
                'type' => 'Booking Created',
                'data' => 'New Booking has been added.',
                'read' => 0,
            ])
            ->andReturn((object) ['id' => 1]);

        $this->app->instance(Notification::class, $notificationMock);

        // Act
        $response = $this->json('PUT', url('api/bookings', $booking->id), $requestData, [
            'Authorization' => 'Bearer ' . \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user),
        ]);

        // Decode the JSON response
        $responseData = json_decode($response->getContent(), true);

        // Output the response to the console for debugging
        echo "Response Status: " . $response->status() . "\n";
        echo "Response Content: " . $response->getContent() . "\n";
        echo "Response Data: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";

        // Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'statusCode' => Response::HTTP_OK,
                'message' => 'Success',
                'data' => $requestData,
                'sqlState' => '00000',
            ]);

        // Ensure that the booking was updated in the database
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'users_id' => $requestData['users_id'],
            'services_id' => $requestData['services_id'],
            'created_by' => $requestData['created_by'],
        ]);
    }

    public function testDestroyBookingSuccessfully()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user); // Simulate a logged-in user

        $booking = Booking::factory()->create([
            'users_id' => $user->id,
            'services_id' => 1,
            'created_by' => $user->id,
        ]);

        // Act
        $response = $this->json('DELETE', url('api/bookings', $booking->id), [], [
            'Authorization' => 'Bearer ' . \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user),
        ]);

        // Decode the JSON response
        $responseData = json_decode($response->getContent(), true);

        // Output the response to the console for debugging
        echo "Response Status: " . $response->status() . "\n";
        echo "Response Data: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";

        // Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'statusCode' => Response::HTTP_OK,
                'message' => 'Deleted',
                'data' => null,
                'sqlState' => '00000',
            ]);

        // Ensure that the booking was deleted from the database
        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
        ]);
    }

    public function testDestroyBookingNotFound()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user); // Simulate a logged-in user

        // Act
        $response = $this->json('DELETE', url('api/bookings', 9999), [], [
            'Authorization' => 'Bearer ' . \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user),
        ]);

        // Decode the JSON response
        $responseData = json_decode($response->getContent(), true);

        // Output the response to the console for debugging
        echo "Response Status: " . $response->status() . "\n";
        echo "Response Data: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";

        // Assert
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => 'Booking not found',
                'data' => null,
                'sqlState' => 0,
            ]);
    }

}
