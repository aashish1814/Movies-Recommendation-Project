#In movie recommender
import numpy as np
import seaborn as sns
import matplotlib.pyplot as plt
from sklearn.metrics import confusion_matrix, accuracy_score, classification_report

# Example data
user_movie = {"name": "Iron Man", "genre": ["Action", "Sci-Fi"]}
recommended_movies = [
  {"name": "Iron Man 2", "genre": ["Action", "Sci-Fi"]},
  {"name": "Iron Man 3", "genre": ["Action", "Sci-Fi"]},
  {"name": "The Avengers", "genre": ["Action", "Sci-Fi"]},
  {"name": "TRON: Legacy", "genre": ["Action", "Sci-Fi"]},
  {"name": "Captain America: Civil War", "genre": ["Action","Sci-Fi"]},
  {"name": "Avengers: Age of Ultron", "genre": ["Action", "Sci-Fi"]},
  {"name": "Pacific Rim", "genre": ["Action", "Sci-Fi"]},
  {"name": "Timeline", "genre": ["Action", "Sci-Fi"]},
  {"name": "Beneath the Planet of the Apes", "genre": ["Action", "Sci-Fi"]},
  {"name": "Star Trek Into Darkness", "genre": ["Action", "Sci-Fi"]},
  {"name": "Notting Hill", "genre": ["Romance", "Comedy"]},
  {"name": "Independence Day", "genre": ["Action", "Sci-Fi"]},
]


# Ground truth: assuming all recommendations are relevant (1)
true_labels = [1] * len(recommended_movies)

# Predicted labels based on genre match
predicted_labels = [
    1 if set(user_movie["genre"]) & set(rec_movie["genre"]) else 0
    for rec_movie in recommended_movies
]

# Define all possible labels
all_labels = [0, 1]

# Calculate metrics
conf_matrix = confusion_matrix(true_labels, predicted_labels, labels=all_labels)
accuracy = accuracy_score(true_labels, predicted_labels)
class_report = classification_report(
    true_labels, predicted_labels, labels=all_labels, target_names=["No Match", "Match"]
)

# Plot confusion matrix
plt.figure(figsize=(10, 10))

# 1. Confusion Matrix
plt.subplot(2, 1, 1)
sns.heatmap(
    conf_matrix,
    annot=True,
    fmt="d",
    cmap="coolwarm",
    cbar=False,
    xticklabels=["No Match", "Match"],
    yticklabels=["No Match", "Match"],
    annot_kws={"size": 14},
)
plt.title("Confusion Matrix", fontsize=18, weight="bold")
plt.xlabel("Predicted Label", fontsize=14)
plt.ylabel("True Label", fontsize=14)
plt.xticks(fontsize=12)
plt.yticks(fontsize=12)

# 2. Metrics Summary
plt.subplot(2, 1, 2)
metrics_text = (
    f"Accuracy: {accuracy:.2f}\n\n"
    f"Classification Report:\n"
    f"{classification_report(true_labels, predicted_labels, labels=all_labels, target_names=['No Match', 'Match'])}"
)
plt.text(0.1, 0.5, metrics_text, fontsize=12, ha="left", va="center", family="monospace", wrap=True)
plt.axis("off")

plt.tight_layout()
plt.show()
