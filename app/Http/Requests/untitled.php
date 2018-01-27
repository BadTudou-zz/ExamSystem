use App\Paper;

$user = Auth::user();
        $paper = Paper::find($this->route('paper'));
        return $user->can('paper-destroy') || $user->id == $organization->creator_id;