require 'test_helper'

class MobilePageControllerTest < ActionController::TestCase
  test "should get oneday" do
    get :oneday
    assert_response :success
  end

  test "should get onemonth" do
    get :onemonth
    assert_response :success
  end

  test "should get fourday" do
    get :fourday
    assert_response :success
  end

end
