class CreatePosts < ActiveRecord::Migration
  def change
    create_table :posts do |t|
      t.string :name
      t.string :title
      t.string :description
      t.string :image

      t.timestamps
    end
  end
end
