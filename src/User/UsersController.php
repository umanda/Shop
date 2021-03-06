<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\User;

use Antvel\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Antvel\User\Requests\ProfileRequest;
use Antvel\User\Events\ProfileWasUpdated;

class UsersController extends Controller
{
    /**
     * The user repository.
     *
     * @var UsersRepository
     */
    protected $user = null;

    /**
     * The view panel layout. (TEMP while refactoring)
     *
     * @var array
     */
    private $view_panel = [
        'left'   => ['width' => '2', 'class' => 'user-panel'],
        'center' => ['width' => '10'],
    ];

    /**
     * Creates a new instance.
     *
     * @param UsersRepository $user
     *
     * @return void
     */
    public function __construct(UsersRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Shows the user profile.
     *
     * @return void
     */
	public function index()
	{
        //might be the user dashboard down on the road.
        return $this->show();
	}

    /**
     * Shows the user profile.
     *
     * @return void
     */
    public function show()
    {
        return view('user.profile', [
            'user' => $this->user->profile(),
            'panel' => $this->view_panel
        ]);
    }

    /**
     * Updates the user profile.
     *
     * @param  ProfileRequest $request
     * @param  int $user
     *
     * @return void
     */
    public function update(ProfileRequest $request, $user_id = null)
    {
        $user = $this->user->profile($user_id);
        $event = new ProfileWasUpdated($request->all(), $user);

        Event::fire($event);

        if ($request->wantsJson()) {
            return $this->respondsWithSuccess('ok');
        }

        return back();
    }

}
