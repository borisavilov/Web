require 'test_helper'

class StaticPagesControllerTest < ActionController::TestCase
  test "should get home" do
    get :home
    assert_response :success
  end

  test "should get findgym" do
    get :findgym
    assert_response :success
  end

  test "should get checkout" do
    get :checkout
    assert_response :success
  end

  test "should get workout" do
    get :workout
    assert_response :success
  end

end
