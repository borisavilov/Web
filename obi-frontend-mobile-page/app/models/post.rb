class Post < ActiveRecord::Base
  attr_accessible :description, :image, :name, :title
end
