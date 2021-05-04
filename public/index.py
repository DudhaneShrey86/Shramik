import sys
import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.tree import export_graphviz
import pydot
import json

features = pd.read_csv("dataset2.csv")

labels = np.array(features['hired'])
features= features.drop('hired', axis = 1)
feature_list = list(features.columns)
features = np.array(features)
train_features, test_features, train_labels, test_labels = train_test_split(features, labels, test_size = 0.25, random_state = 42)

rf = RandomForestRegressor(n_estimators = 1000, random_state = 42)
rf.fit(train_features, train_labels);

arr = json.loads(sys.argv[1])


predictions = rf.predict(arr)
print(predictions.tolist())
# errors = abs(predictions - test_labels)


# print('Mean Absolute Error:', round(np.mean(errors), 2), 'degrees.')
#
# tree = rf.estimators_[5]
# export_graphviz(tree, out_file = 'tree.dot', feature_names = feature_list, rounded = True, precision = 1)
# (graph, ) = pydot.graph_from_dot_file('tree.dot')
# graph.write_png('tree.png')
#
# importances = list(rf.feature_importances_)
# feature_importances = [(feature, round(importance, 2)) for feature, importance in zip(feature_list, importances)]
# feature_importances = sorted(feature_importances, key = lambda x: x[1], reverse = True)
# [print('Variable: {:20} Importance: {}'.format(*pair)) for pair in feature_importances];
