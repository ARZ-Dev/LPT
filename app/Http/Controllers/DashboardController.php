<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\PricingRequest;
use App\Utils\Constants;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function pages()
    {
        $user = auth()->user();
        $pages =  [];

        // Offers / Bids
        if ($user->can('offer-list')) {
            $pages[] = [
                "name" => "Bids",
                "icon" => "ti-news",
                "url" => route('bids'),
            ];
        }

        // Pricing Requests
        if ($user->can('pricingRequest-list')) {
            $pages[] = [
                "name" => "Pricing Requests",
                "icon" => "ti-report-money",
                "url" => route('pricing-requests'),
            ];
        }

        // Dashboard
        if (true) {
            $pages[] = [
                "name" => "Dashboard - Report",
                "icon" => "ti-report",
                "url" => route('dashboard'),
            ];
        }

        // Items
        if ($user->can('item-list')) {
            $pages[] = [
                "name" => "Settings - Items",
                "icon" => "ti-box",
                "url" => route('items'),
            ];
        }

        // Roles
        if ($user->can('role-list')) {
            $pages[] = [
                "name" => "Settings - Roles",
                "icon" => "ti-settings",
                "url" => route('roles'),
            ];
        }

        // Permissions
        if ($user->can('permission-list')) {
            $pages[] = [
                "name" => "Settings - Permissions",
                "icon" => "ti-settings",
                "url" => route('permissions'),
            ];
        }

        // Suppliers
        if ($user->can('supplier-list')) {
            $pages[] = [
                "name" => "Settings - Suppliers",
                "icon" => "ti-building-warehouse",
                "url" => route('suppliers'),
            ];
        }

        // Incoterms
        if ($user->can('incoterm-list')) {
            $pages[] = [
                "name" => "Settings - Incoterms",
                "icon" => "ti-truck-delivery",
                "url" => route('incoterms'),
            ];
        }

        // Users
        if ($user->can('user-list')) {
            $pages[] = [
                "name" => "Settings - Users",
                "icon" => "ti-users",
                "url" => route('users'),
            ];
        }

        if ($user->can('offer-view')) {
            $offers = Offer::all();
            foreach ($offers as $offer) {
                $pages[] = [
                    "name" => "Bids - $offer->reference_id",
                    "icon" => "ti-news",
                    "url" => route('bids.view', [$offer->id, Constants::VIEW_STATUS]),
                ];
            }
        }

        if ($user->can('pricingRequest-view')) {
            $pricingRequests = PricingRequest::all();
            foreach ($pricingRequests as $pricingRequest) {
                $pages[] = [
                    "name" => "Pricing Requests - $pricingRequest->reference_id",
                    "icon" => "ti-report-money",
                    "url" => route('pricing-requests.view', [$pricingRequest->id, Constants::VIEW_STATUS]),
                ];
            }
        }

        return response()->json(['pages' => $pages]);
    }
}
