<?php
namespace App\Enums\Order;

enum OrderStatusEnum: string
{
    case Pending = 'pending';
    case Preparing = 'preparing';
    case Completed = 'completed';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
    case Returned = 'returned';
}
