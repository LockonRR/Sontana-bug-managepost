<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    // กำหนดชื่อของตาราง
    protected $table = 'reports';

    // กำหนดค่าฟิลด์ที่สามารถทำการ Mass Assignment ได้
    protected $fillable = [
        'reporter_id',
        'post_id',
        'comment_id',
        'reason',
        'status',
    ];

    // สัมพันธ์กับ User (ผู้รายงาน)
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // สัมพันธ์กับ Post (โพสต์)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // สัมพันธ์กับ Comment (ความคิดเห็น)
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
